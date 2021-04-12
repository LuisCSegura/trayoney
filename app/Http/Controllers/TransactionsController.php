<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use App\Models\Currency;
use Exception;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TransactionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->toIndex(null);
    }
    private function toIndex($message)
    {
        $mesactual = date("m");
        $transactions = Transaction::where(['user_id' => Auth::user()->id])->whereMonth('updated_at', '=', $mesactual)->latest()->get();
        return view('transactions.index', ['transactions' => $transactions, 'error' => $message]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validateTransaction();
            $transaction = new Transaction(request([
                'account_id',
                'category_id',
                'destination_account_id',
                'detail',
                'amount',
                'type'
            ]));
            $transaction->user_id = Auth::user()->id;
            $this->releaseTransaction($transaction);
            $transaction->save();
            return redirect('/transactions');
        } catch (\Throwable $th) {
            return $this->toIndex($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transactions $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        try {
            $this->validateTransaction();
            $this->relaunchTransaction($transaction, $request->amount);
            $transaction->destination_account_id = $request->destination_account_id;
            $transaction->category_id = $request->category_id;
            $transaction->account_id = $request->account_id;
            $transaction->detail = $request->detail;
            $transaction->type = $request->type;
            $transaction->amount = $request->amount;
            $transaction->update();
            return redirect('/transactions');
        } catch (\Throwable $th) {
            return $this->toIndex($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transactions $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $this->rollbackTransaction($transaction);
            $transaction->delete();
            return redirect('/transactions');
        } catch (\Throwable $th) {
            return $this->toIndex($th->getMessage());
        }
    }
    protected function validateTransaction()
    {
        return request()->validate([
            'account_id' => 'required',
            'detail' => 'required',
            'amount' => 'required',
            'type' => 'required',
        ]);
    }
    protected function baseToOther($amount, Currency $otherCurrency)
    {
        return round($amount / $otherCurrency->rate, 2);
    }
    protected function releaseTransaction(Transaction $transaction)
    {
        $convertedAmount = $this->baseToOther($transaction->amount, $transaction->account->currency);
        if ($transaction->type == "INCOME") {
            $transaction->account->balance += $convertedAmount;
        } elseif ($transaction->type == "EXPENSE") {
            $transaction->account->balance -= $convertedAmount;
            if (($transaction->account->balance < 0) && $transaction->account->is_debit) {
                throw new Exception("The transaction could not be completed because the originating account does not have enough balance");
            }
        } else {
            $transaction->account->balance -= $convertedAmount;
            $transaction->destination_account->balance += $this->baseToOther($transaction->amount, $transaction->destination_account->currency);
            if (($transaction->account->balance < 0) && $transaction->account->is_debit) {
                throw new Exception("The transaction could not be completed because the originating account does not have enough balance");
            }
            $transaction->destination_account->update();
        }
        $transaction->account->update();
    }
    protected function relaunchTransaction(Transaction $transaction, $newAmount)
    {
        $convertedAmount = $this->baseToOther($transaction->amount, $transaction->account->currency);
        $convertedNewAmount = $this->baseToOther($newAmount, $transaction->account->currency);
        if ($transaction->type == "INCOME") {
            $transaction->account->balance -= $convertedAmount;
            $transaction->account->balance += $convertedNewAmount;
            if (($transaction->account->balance < 0) && $transaction->account->is_debit) {
                throw new Exception("The transaction could not be relaunched because the destination account does not have enough balance");
            }
        } elseif ($transaction->type == "EXPENSE") {
            $transaction->account->balance += $convertedAmount;
            $transaction->account->balance -= $convertedNewAmount;
            if (($transaction->account->balance < 0) && $transaction->account->is_debit) {
                throw new Exception("The transaction could not be relaunched because the originating account does not have enough balance");
            }
        } else {
            $transaction->account->balance += $convertedAmount;
            $transaction->account->balance -= $convertedNewAmount;
            $transaction->destination_account->balance -= $this->baseToOther($transaction->amount, $transaction->destination_account->currency);
            $transaction->destination_account->balance += $this->baseToOther($newAmount, $transaction->destination_account->currency);
            if (($transaction->destination_account->balance < 0) && $transaction->destination_account->is_debit) {
                throw new Exception("The transaction could not be relaunched because the destination account does not have enough balance");
            }
            if (($transaction->account->balance < 0) && $transaction->account->is_debit) {
                throw new Exception("The transaction could not be relaunched because the originating account does not have enough balance");
            }
            $transaction->destination_account->update();
        }
        $transaction->account->update();
    }
    protected function rollbackTransaction(Transaction $transaction)
    {
        $convertedAmount = $this->baseToOther($transaction->amount, $transaction->account->currency);
        if ($transaction->type == "INCOME") {
            $transaction->account->balance -= $convertedAmount;
            if (($transaction->account->balance < 0) && $transaction->account->is_debit) {
                throw new Exception("The rollback could not be completed because the destination account does not have enough balance");
            }
        } elseif ($transaction->type == "EXPENSE") {
            $transaction->account->balance += $convertedAmount;
        } else {
            $transaction->account->balance += $convertedAmount;
            $transaction->destination_account->balance -= $this->baseToOther($transaction->amount, $transaction->destination_account->currency);
            if (($transaction->destination_account->balance < 0) && $transaction->destination_account->is_debit) {
                throw new Exception("The rollback could not be completed because the destination account does not have enough balance");
            }
            $transaction->destination_account->update();
        }
        $transaction->account->update();
    }
}

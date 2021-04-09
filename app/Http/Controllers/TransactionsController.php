<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
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
        $transactions = Transaction::where(['user_id' => Auth::user()->id])->latest()->get();
        return view('transactions.index', ['incomes' => $transactions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $transaction->save();
        return redirect('/transactions');
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
        $transaction->update($this->validateTransaction());
        return redirect('/transactions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transactions $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return redirect('/transactions');
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
}

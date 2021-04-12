<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AccountsController extends Controller
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
        $accounts = Account::where('user_id', Auth::user()->id)->latest()->get();
        return view('accounts.index', ['accounts' => $accounts, 'error' => $message]);
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
            $this->validateAccount();
            $account = new Account(request(['currency_id', 'abbreviation', 'name', 'balance', 'is_debit']));
            $account->user_id = Auth::user()->id;
            $account->save();
            return redirect('/accounts');
        } catch (\Throwable $th) {
            return $this->toIndex($th->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        try {
            $account->update($this->validateAccount());
            return redirect('/accounts');
        } catch (\Throwable $th) {
            return $this->toIndex($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $account = Account::findOrFail($id);
            $account->delete();
            return redirect('/accounts');
        } catch (\Throwable $th) {
            return $this->toIndex($th->getMessage());
        }
    }
    protected function validateAccount()
    {
        return request()->validate([
            'currency_id' => 'required',
            'abbreviation' => 'required',
            'name' => 'required',
            'is_debit' => 'required',
            'balance' => 'required'
        ]);
    }
    public function shareAccount(Account $account)
    {
        try {
            $user = User::where('email', request()->email)->first();
            if ($user == null) {
                throw new Exception("The email provided does not match any registered user");
            }
            $user->shared_accounts()->attach($account);
            return redirect('/accounts');
        } catch (\Throwable $th) {
            return $this->toIndex($th->getMessage());
        }
    }
}

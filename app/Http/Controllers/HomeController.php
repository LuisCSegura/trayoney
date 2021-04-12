<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return $this->toIndex(null);
    }
    private function toIndex($message)
    {
        $actualMonth = date("m");
        $stats = [];
        $incomeAmount = Transaction::where([['user_id', '=', Auth::user()->id], ['type', '=', 'INCOME']])->whereMonth('updated_at', '=', $actualMonth)->sum('amount');
        $expenseAmount = Transaction::where([['user_id', '=', Auth::user()->id], ['type', '=', 'EXPENSE']])->whereMonth('updated_at', '=', $actualMonth)->sum('amount');
        array_push($stats, ["INCOMES", $incomeAmount, '#1E90FF'], ["EXPENSES", $expenseAmount, '#DC143C']);
        rsort($stats);
        // dd($stats);
        return view('home', ['stats' => $stats, 'error' => $message]);
    }
}

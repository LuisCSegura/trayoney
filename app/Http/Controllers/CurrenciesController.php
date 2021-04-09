<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrenciesController extends Controller
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
        $currencies = Currency::where('user_id', Auth::user()->id)->latest()->get();
        return view('currencies.index', ['currencies' => $currencies]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateCurrency();
        $currency = new Currency(request(['base_currency_user_id', 'abbreviation', 'name', 'simbol', 'rate']));
        $currency->user_id = Auth::user()->id;
        $currency->save();
        return redirect('/currencies');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        $currency->update($this->validateCurrency());
        return redirect('/currencies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currency = Currency::findOrFail($id);
        $currency->delete();
        return redirect('/currencies');
    }
    protected function validateCurrency()
    {
        return request()->validate([
            'abbreviation' => 'required',
            'name' => 'required',
            'simbol' => 'required',
            'rate' => 'required'
        ]);
    }
}

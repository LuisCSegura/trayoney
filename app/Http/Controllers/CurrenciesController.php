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
        return $this->toIndex(null);
    }
    private function toIndex($message)
    {
        $currencies = Currency::where('user_id', Auth::user()->id)->latest()->get();
        return view('currencies.index', ['currencies' => $currencies, 'error' => $message]);
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
            $this->validateCurrency();
            $currency = new Currency(request(['base_currency_user_id', 'abbreviation', 'name', 'simbol', 'rate']));
            $currency->user_id = Auth::user()->id;
            $currency->save();
            return redirect('/currencies');
        } catch (\Throwable $th) {
            return $this->toIndex($th->getMessage());
        }
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
        try {
            $currency->update($this->validateCurrency());
            return redirect('/currencies');
        } catch (\Throwable $th) {
            return $this->toIndex($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $currency = Currency::findOrFail($id);
            $currency->delete();
            return redirect('/currencies');
        } catch (\Throwable $th) {
            return $this->toIndex($th->getMessage());
        }
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

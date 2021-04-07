<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//google auth
Route::get('auth/google', [App\Http\Controllers\GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [App\Http\Controllers\GoogleController::class, 'handleGoogleCallback']);
//currencies
Route::get('/currencies', [App\Http\Controllers\CurrenciesController::class, 'index']);
Route::post('/currencies', [App\Http\Controllers\CurrenciesController::class, 'store']);
Route::put('/currencies/{currency}', [App\Http\Controllers\CurrenciesController::class, 'update'])->name('currencies.update');
Route::delete('/currencies/{currency}', [App\Http\Controllers\CurrenciesController::class, 'destroy'])->name('currencies.destroy');

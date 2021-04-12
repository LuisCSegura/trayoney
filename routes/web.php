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
//accounts
Route::get('/accounts', [App\Http\Controllers\AccountsController::class, 'index']);
Route::post('/accounts', [App\Http\Controllers\AccountsController::class, 'store']);
Route::put('/accounts/{account}', [App\Http\Controllers\AccountsController::class, 'update']);
Route::delete('/accounts/{account}', [App\Http\Controllers\AccountsController::class, 'destroy']);
Route::post('/accounts/{account}', [App\Http\Controllers\AccountsController::class, 'shareAccount']);
//categories
Route::get('/categories', [App\Http\Controllers\CategoriesController::class, 'index']);
Route::post('/categories', [App\Http\Controllers\CategoriesController::class, 'store']);
Route::put('/categories/{category}', [App\Http\Controllers\CategoriesController::class, 'update']);
Route::delete('/categories/{category}', [App\Http\Controllers\CategoriesController::class, 'destroy']);
//transactions
Route::get('/transactions', [App\Http\Controllers\TransactionsController::class, 'index']);
Route::post('/transactions', [App\Http\Controllers\TransactionsController::class, 'store']);
Route::put('/transactions/{transaction}', [App\Http\Controllers\TransactionsController::class, 'update']);
Route::delete('/transactions/{transaction}', [App\Http\Controllers\TransactionsController::class, 'destroy']);

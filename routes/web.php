<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\MainPageController::class, 'index']);

Route::get('/dashboard', [App\Http\Controllers\StocksController::class, 'getStocks'])
    ->middleware(['auth'])->name('dashboard');

Route::get('/stock', [App\Http\Controllers\StocksController::class, 'getStockInfo'])
    ->middleware(['auth'])->name('stock');

Route::get('/search', [App\Http\Controllers\StocksController::class, 'searchStock'])
    ->middleware(['auth'])->name('search');

Route::post('/purchase', [App\Http\Controllers\TransactionController::class, 'transaction'])
    ->middleware(['auth'])->name('purchase');

Route::get('/transactions-history', [App\Http\Controllers\PortfolioController::class, 'showTransactions'])
    ->middleware(['auth'])->name('transactions-history');

Route::get('/portfolio', [App\Http\Controllers\PortfolioController::class, 'showPortfolio'])
    ->middleware(['auth'])->name('portfolio');

Route::get('/new-password', [App\Http\Controllers\Auth\NewPasswordController::class, 'create'])
    ->middleware(['auth'])->name('auth.reset-password');

Route::post('/new-password', [App\Http\Controllers\Auth\NewPasswordController::class, 'store'])
    ->middleware(['auth'])->name('auth.reset-password');


require __DIR__.'/auth.php';

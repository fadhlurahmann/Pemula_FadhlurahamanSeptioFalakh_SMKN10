<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/logoutmanual', [App\Http\Controllers\HomeController::class, 'logoutmanual']);

Route::resource('product', ProductController::class);
Route::post('/download', [TransactionController::class, 'download'])->name('download');
Route::post('/addToCart', [TransactionController::class, 'addToCart'])->name('addToCart');
Route::post('/payNow', [TransactionController::class, 'payNow'])->name('payNow');
Route::post('TopUpNow', [WalletController::class, 'TopUpNow'])->name('TopUpNow');
Route::post('/topup-from-bank', [WalletController::class, 'topupFromBank']);
Route::post('/withdraw-from-bank', [WalletController::class, 'withdrawFromBank']);
Route::post('withdrawNow', [WalletController::class, 'withdrawNow'])->name('withdrawNow');
Route::get('/download/{order_code}', [TransactionController::class, 'download'])->name('download');
Route::post('request_topup', [WalletController::class, 'request_topup'])->name('request_topup');
Route::resource('user', UserController::class);


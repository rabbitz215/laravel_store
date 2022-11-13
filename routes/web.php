<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;

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

Route::get('/', [ShopController::class, 'index'])->name('index');
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('checkout', [ShopController::class, 'checkoutList'])->name('checkout.list');
    Route::post('checkout', [ShopController::class, 'addToCheckout'])->name('checkout.store');
    Route::post('checkout-db', [ShopController::class, 'store'])->name('checkout.db');
    Route::post('update-checkout', [ShopController::class, 'updateCheckout'])->name('checkout.update');
    Route::post('remove-checkout', [ShopController::class, 'removeCheckout'])->name('checkout.remove');
    Route::post('clear-checkout', [ShopController::class, 'clearAllcheckout'])->name('checkout.clear');
});

Auth::routes();

Route::middleware(['auth', 'role:admin|moderator'])->group(function () {
    Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
    Route::post('cart', [CartController::class, 'addToCart'])->name('cart.store');
    Route::post('cart-db', [CartController::class, 'store'])->name('cart.db');
    Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('remove', [CartController::class, 'removeCart'])->name('cart.remove');
    Route::post('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');

    Route::resource('/transaction', TransactionController::class);

    Route::resource('/users', UserController::class);

    Route::get('/admin', [HomeController::class, 'home'])->name('admin');

    Route::resource('/product', ProductController::class)->parameters([
        'product' => 'product:slug'
    ]);
    Route::resource('/category', CategoryController::class)->parameters([
        'category' => 'category:slug'
    ]);
});

<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'home'])->name('home');
Route::get('/books', [BookController::class, 'index'])->name('books.index');

Route::get('/google-books/recommendations', [BookController::class, 'loadMoreRecommendations'])
    ->name('google-books.recommendations');

Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/cart/add/{book}', [CartController::class, 'add'])
    ->name('cart.add');

Route::post('/cart/update/{book}', [CartController::class, 'update'])
    ->name('cart.update');

Route::post('/cart/remove/{book}', [CartController::class, 'remove'])
    ->name('cart.remove');
Route::post('/checkout/preview', [CheckoutController::class, 'preview'])
    ->name('checkout.preview');

Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])
    ->name('checkout.place-order');
Route::get('/admin/login', [AuthController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AuthController::class, 'login'])
    ->name('admin.login.submit');

Route::post('/admin/logout', [AuthController::class, 'logout'])
    ->name('admin.logout');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::resource('books', AdminBookController::class)
        ->names('admin.books');

    Route::get('/orders', [OrderController::class, 'index'])
        ->name('admin.orders.index');

    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('admin.orders.update-status');
});

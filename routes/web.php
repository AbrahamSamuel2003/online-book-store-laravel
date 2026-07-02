<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'home'])->name('home');
Route::get('/books', [BookController::class, 'index'])->name('books.index');

Route::get('/google-books/recommendations', [BookController::class, 'loadMoreRecommendations'])
    ->name('google-books.recommendations');

Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
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
});

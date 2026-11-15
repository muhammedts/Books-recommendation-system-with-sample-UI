<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::pattern('book', '[0-9]+');

Route::redirect('/', '/books')->name('home');

// Browsing and searching is open to everyone.
Route::resource('books', BookController::class)->only(['index', 'show']);

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->middleware('throttle:10,1');
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('dashboard', DashboardController::class)->name('dashboard');

    // Creating, editing and deleting books is limited to admins by BookPolicy.
    Route::resource('books', BookController::class)->except(['index', 'show']);

    Route::post('books/{book}/rating', [RatingController::class, 'store'])->name('books.rating.store');
    Route::post('books/{book}/reviews', [ReviewController::class, 'store'])->name('books.reviews.store');
});

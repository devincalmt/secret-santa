<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'showLoginForm']);
Route::post('/login', [HomeController::class, 'login'])->name('login');

Route::post('/add-my-wishlist', [WishlistController::class, 'addMyWishlist'])->name('add-my-wishlist');
Route::post('/remind-to-fill', [WishlistController::class, 'remindToFill'])->name('remind-to-fill');

Route::get('/{id}', [HomeController::class, 'redirectAfterLogin'])->name('dashboard');
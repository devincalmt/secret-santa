<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'showLoginForm']);

Route::post('/login', [HomeController::class, 'login'])->name('login');

Route::get('/{id}', [HomeController::class, 'redirectAfterLogin'])->name('dashboard');
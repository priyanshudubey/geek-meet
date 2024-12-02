<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/signup', function () {
    return view('signup');
});

Route::post('/signup', [AuthController::class, 'signup'])->name('signup');

// Show login form
Route::get('/login', function () {
    return view('login');
})->name('login');

// Handle login
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Show home page (protected route)
Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/posts', [PostController::class, 'store'])->middleware('auth');
Route::get('/posts', [PostController::class, 'fetchPosts'])->middleware('auth');
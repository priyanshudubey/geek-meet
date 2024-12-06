<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Models\Post;
use App\Http\Controllers\NotificationController;

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
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

Route::post('/posts/{post}/comments', [CommentController::class, 'store']);

Route::post('/posts/{post}/like', [LikeController::class, 'toggleLike'])->middleware('auth');

Route::get('/notifications', [NotificationController::class, 'index']);
Route::post('/notifications/read', [NotificationController::class, 'markAsRead']);
Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

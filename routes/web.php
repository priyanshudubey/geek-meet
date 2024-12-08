<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Models\Post;
use App\Http\Controllers\ProfileController;

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Handle login
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Protected routes
Route::middleware('auth')->get('/home', function () {
    $posts = Post::with(['user', 'comments', 'likes'])->get();
    return view('home', compact('posts'));
})->name('home');

    Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Posts
    Route::post('/posts', [PostController::class, 'store'])->middleware('auth');
    Route::get('/posts', [PostController::class, 'fetchPosts'])->middleware('auth')->name('posts.fetch');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->middleware('auth');


    // Likes
    Route::post('/posts/{post}/like', [LikeController::class, 'toggleLike']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

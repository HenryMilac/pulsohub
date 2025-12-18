<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'index'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/images', [ImageController::class, 'store'])->name('images.store');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/likes/{post}', [LikeController::class, 'store'])->name('likes.store');
    Route::delete('/likes/{like}', [LikeController::class, 'destroy'])->name('likes.destroy');
    Route::get('/edit-profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/edit-profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/{user:name}/follow', [FollowerController::class, 'store'])->name('users.follow');
    Route::delete('/{user:name}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');
    Route::post('/logout', [LogoutController::class, 'store'])->name('logout');
});
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/{user:name}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/{user:name}', [UserController::class, 'index'])->name('user.name');

<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;


Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::post('/login', [LoginController::class, 'store'])->name('login');
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/{user:name}', [UserController::class, 'index'])->name('user.name');
Route::get('/{user:name}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'index'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/images', [ImageController::class, 'store'])->name('images.store');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
});

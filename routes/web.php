<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('principal');
});
Route::get('/register', [RegisterController::class, 'index']);
Route::get('/login', function () {
    return view('auth.login');
});

<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Redirect authenticated users trying to access guest pages to their profile
        $middleware->redirectUsersTo(function () {
            return route('user.profile', Auth::user()->username);
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

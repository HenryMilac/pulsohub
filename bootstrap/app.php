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
            // TODO: ver si redijira con el name o username, ya que username será unico y name puede haber varios iguales
            return route('user.name', Auth::user()->name);
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

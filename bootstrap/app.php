<?php

use App\Http\Middleware\CheckIfBanned;
use Illuminate\Foundation\Application;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\EnsurePhoneIsSet;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(CheckIfBanned::class);
        
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'ensure.phone' => EnsurePhoneIsSet::class,
            'check.banned' => CheckIfBanned::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

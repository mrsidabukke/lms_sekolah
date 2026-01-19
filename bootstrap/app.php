<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__.'/../routes/web.php',

        // ✅ PAKSA API PAKAI PREFIX & MIDDLEWARE
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api',

        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {
        // ✅ REGISTER ALIAS MIDDLEWARE
        $middleware->alias([
            'student' => \App\Http\Middleware\EnsureUserIsStudent::class,
            'teacher' => \App\Http\Middleware\EnsureUserIsTeacher::class,
        ]);

        // ✅ REGISTER API MIDDLEWARE GROUP
        $middleware->group('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();

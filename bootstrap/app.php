<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Http\Middleware\EstaActivoMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'activo' => EstaActivoMiddleware::class,
            'role'=> RoleMiddleware::class,
            'permission' => PermissionMiddleware::class
        ]);

        $middleware->validateCsrfTokens(except:['acredita_pago']);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

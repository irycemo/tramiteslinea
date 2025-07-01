<?php

use Illuminate\Support\Facades\Route;
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
        apiPrefix: 'api/v1',
        then: function(){

            Route::middleware(['web', 'auth', 'esta.activo'])->group(base_path('routes/administrador.php'));

            Route::middleware(['web', 'auth', 'esta.activo'])->group(base_path('routes/catastro.php'));

            Route::middleware(['web', 'auth', 'esta.activo'])->group(base_path('routes/rpp.php'));

        }
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'esta.activo' => EstaActivoMiddleware::class,
            'role'=> RoleMiddleware::class,
            'permission' => PermissionMiddleware::class
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

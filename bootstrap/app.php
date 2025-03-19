<?php

use App\Http\Middleware\CheckDeviceLimit;
use App\Http\Middleware\LogoutDevice;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
            ->prefix('api')
            ->name('api.')
            ->group(__DIR__ . '/../routes/api.php');
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias(
            [
                'check.device.limit' => CheckDeviceLimit::class,
                'logout.device' => LogoutDevice::class
            ]
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

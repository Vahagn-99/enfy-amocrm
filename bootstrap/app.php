<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath : dirname(__DIR__))
    ->withRouting(
        web : [
            __DIR__.'/../routes/web.php',
        ],
        health : '/up',
        then : function () {
            Route::middleware('api')
                ->group([
                    base_path('routes/amocrm.php'),
                ]);
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withProviders([
        App\Providers\EventServiceProvider::class,
        App\Providers\ScheduleServiceProvider::class,
        App\Providers\HorizonServiceProvider::class,
        App\Providers\AmoCRMServiceProvider::class,
    ])
    ->create();

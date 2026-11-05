<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Providers\HashidsServiceProvider;
// use App\Facades\Hashids;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withProviders([
        HashidsServiceProvider::class,
    ])
    ->withMiddleware(function (Middleware $middleware) {

        // Confiar en todos los proxies (necesario para Cloudflare Tunnel)
        $middleware->trustProxies(at: '*');

        // Registrar alias para tu middleware personalizado
        $middleware->alias([
            'verificarUsuario' => \App\Http\Middleware\VerificarUsuario::class,
            'authaw' => \App\Http\Middleware\Authaw::class,
            'guestaw' => \App\Http\Middleware\Guestaw::class,
        ]);

        // Si deseas que sea global (opcional):
        // $middleware->append(\App\Http\Middleware\VerificarUsuario::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

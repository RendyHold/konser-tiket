<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// >> tambahkan use untuk middleware kamu
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    // Routing bawaan
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    // === Di Laravel 11, daftar middleware di sini ===
    ->withMiddleware(function (Middleware $middleware) {
        // Alias route middleware (ganti 'role' jadi nama alias yang kamu pakai di routes)
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);

        // (Opsional) grup khusus
        $middleware->group('petugas', ['auth', 'role:petugas']);
        $middleware->group('admin',   ['auth', 'role:admin']);
    })

    // (opsional) handler exception
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

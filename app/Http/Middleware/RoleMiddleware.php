<?php

// app/Http/Middleware/RoleMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$allowedRoles)
    {
        $user = $request->user();
        if (!$user) abort(401);

        // izinkan admin untuk semua area
        if ($user->role === 'admin') return $next($request);

        if (!in_array($user->role, $allowedRoles, true)) {
            abort(403, 'Anda tidak memiliki akses.');
        }
        return $next($request);
    }
}


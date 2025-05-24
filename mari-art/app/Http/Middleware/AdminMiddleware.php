<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('AdminMiddleware: Checking user', [
            'user' => auth()->user(),
            'is_admin' => auth()->user() ? auth()->user()->is_admin : null
        ]);

        if (!auth()->check() || !auth()->user()->is_admin) {
            Log::warning('AdminMiddleware: Access denied', [
                'user' => auth()->user(),
                'is_admin' => auth()->user() ? auth()->user()->is_admin : null
            ]);
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
} 
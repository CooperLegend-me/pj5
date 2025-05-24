<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleCharset
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Устанавливаем кодировку UTF-8 для всех ответов
        $response->header('Content-Type', $response->headers->get('Content-Type') . '; charset=utf-8');

        return $response;
    }
} 
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventBackCache
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Set các header để ngăn lưu cache
        return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate') // HTTP 1.1
            ->header('Pragma', 'no-cache') // HTTP 1.0
            ->header('Expires', '0'); // Proxies
    }
}

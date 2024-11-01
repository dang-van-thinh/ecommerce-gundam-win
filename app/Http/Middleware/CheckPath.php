<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPath
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('admin/*') && !preg_match('/^[a-zA-Z0-9_\-\/]+$/', $request->path())) {
            return response()->view('errors.404-admin', [], 404);
        }

        return $next($request);
    }
}

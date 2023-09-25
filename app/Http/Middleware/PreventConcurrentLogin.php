<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PreventConcurrentLogin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // User is already authenticated; redirect them to the dashboard or another route
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}

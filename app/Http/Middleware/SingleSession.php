<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SingleSession
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $sessionKey = Auth::user()->getAuthIdentifier();
            $activeSession = session()->getHandler()->read($sessionKey);

            if ($activeSession) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'You are already logged in.');
            } else {
                session()->getHandler()->write($sessionKey, session()->getId());
            }
        }

        return $next($request);
    }

 

// public function handle($request, Closure $next)
// {
//     if (Auth::check()) {
//         $userId = Auth::user()->getAuthIdentifier();
//         $sessionExists = DB::table('sessions')
//             ->where('user_id', $userId)
//             ->exists();

//         if ($sessionExists) {
//             Auth::logout();
//             return redirect()->route('login')->with('error', 'You are already logged in.');
//         }
//     }

//     return $next($request);
// }
}
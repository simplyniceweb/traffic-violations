<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfBanned
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_banned) {
            $reason = Auth::user()->banned_reason ?? 'No reason specified.';

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

             return response()->view('errors.banned', ['reason' => $reason], 403);
        }

        return $next($request);
    }
}


<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EnsurePhoneIsSet
{
    public function handle(Request $request, Closure $next)
    {
        $officer = Auth::user();

        if ($officer && !$officer->phone) {
            return redirect()->route('profile.edit')->with('status', 'phone');
        }

        return $next($request);
    }
}
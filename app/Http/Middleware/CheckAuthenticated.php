<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckAuthenticated
{
    public function handle($request, Closure $next)
    {
        // Jika session "auth_token" tidak ada, redirect ke login
        if (!Session::has('token')) {
            return redirect()->route('login');
        }

        // Jika ada, lanjutkan request
        return $next($request);
    }
}

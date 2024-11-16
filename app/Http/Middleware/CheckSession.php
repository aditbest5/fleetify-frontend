<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckSession
{
    public function handle($request, Closure $next)
    {
        // Jika session "auth_token" ada, redirect ke dashboard
        if (Session::has('token')) {
            return redirect()->route('dashboard');
        }

        // Jika tidak ada, lanjutkan request
        return $next($request);
    }
}

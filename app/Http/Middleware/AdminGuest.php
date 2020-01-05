<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Class AdminGuest
 */
class AdminGuest
{
    /**
     * It is a middleware which handle the logged out or guest user for Admin Module
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::guard($guard)->user()->role == 1 || Auth::guard($guard)->user()->role == 2
            || Auth::guard($guard)->user()->role == 3)
                return redirect('/dashboard');
            else
                return redirect('/logout');
        }
        return $next($request);
    }
}

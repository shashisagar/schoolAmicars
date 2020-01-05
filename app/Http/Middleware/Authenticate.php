<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Class Authenticate
 */
class Authenticate
{

    /**
     * It is a middleware which handle the logged in admin user before starting web application.
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/');
            }
        } else {
            if (Auth::guard($guard)->user()->role == 1 || Auth::guard($guard)->user()->role == 2
            || Auth::guard($guard)->user()->role == 3)
                return $next($request);
            else
                return redirect('/logout');
        }

    }
}

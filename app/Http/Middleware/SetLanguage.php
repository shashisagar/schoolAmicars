<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

/**
 * Class SetLanguage
 * @package App\Http\Middleware
 */
class SetLanguage
{
    /**
     * It sets the current language in app config file
     */
    public function __construct()
    {
        $lang = Session::get('locale');
        if ($lang != null) App::setLocale($lang);
    }

    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}

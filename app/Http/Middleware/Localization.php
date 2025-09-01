<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = config('app.locale');

        if (session()->has('locale')) {
            $locale = session()->get('locale');
        }
        else {
            //$locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            $locale = 'ms';
            if ($locale != 'en' && $locale != 'ms') {
                $locale = config('app.locale');
            }
            session()->put('locale', $locale);
        }
        app()->setLocale($locale);
        return $next($request);
    }
}
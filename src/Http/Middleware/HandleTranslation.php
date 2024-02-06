<?php

namespace Manifesthq\Translation\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
// Use Log 
use Illuminate\Support\Facades\Log;


class HandleTranslation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->is('language/*')) {
            return $next($request);
        }

        if (Session::has('locale')) {
            $sessionLocale = Session::get('locale');
            Log::info('Current Session Locale is ' . $sessionLocale);

            $appLocale = App::getLocale();
            Log::info('App Locale is ' . $appLocale);

            if ($sessionLocale != $appLocale) {
                App::setLocale($sessionLocale);
            }
        } else {
            $appLocale = App::getLocale();
            Log::info('App Locale is ' . $appLocale);

            $defaultLocale = config('translation.default_locale');
            Log::info('Current Config Locale is ' . $defaultLocale);

            // Compare $appLocale and $defaultLocale
            if ($appLocale != $defaultLocale) {
                App::setLocale($defaultLocale);
                Session::put('locale', $defaultLocale);
            }
        }

        return $next($request);
    }
}

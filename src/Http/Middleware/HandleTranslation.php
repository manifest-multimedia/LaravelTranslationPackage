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

        $locale=$request->route('locale');

        if ($locale) {
            App::setLocale($locale);
            Session::put('locale', $locale);
            Log::info('Locale updated to ' . $locale);
        }else{

            App::setLocale(config('translation.default_locale'));
            Session::put('locale', config('translation.default_locale'));
            Log::info('Locale set to defaults ' . config('translation.default_locale'));
        }
        

        return $next($request);
    }
}

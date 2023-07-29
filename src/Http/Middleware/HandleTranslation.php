<?php

namespace Manifesthq\Translation\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


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

        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }else {
            App::setLocale(config('translation.default_locale'));
            Session::put('locale',config('translation.default_locale'));
        }

        return $next($request);

    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization {

    public function handle(Request $request, Closure $next) {

        if (!Session::has('app_locale')) {
            Session::put('app_locale', config('app.locale'));
            Session::save(); 
        }

        $locale = Session::get('app_locale', config('app.locale'));

        App::setLocale($locale);
        config(['app.locale' => $locale]);

        // DD POUR AFFICHER LES INFOS MIDDLEWARE

        // dd([
        //     'middleware_started' => true,
        //     'session_locale' => $locale,
        //     'app_locale' => App::getLocale(),
        //     'config_locale' => config('app.locale'),
        //     'session_datas' => session()->all()
        // ]);

        return $next($request);
    }
}
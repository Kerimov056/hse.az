<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class SetLocale
{
    /** Layihədə dəstəklənən dillər */
    protected array $supported = ['az', 'en', 'ru'];

    public function handle($request, Closure $next)
    {
        $supported = ['az', 'en', 'ru'];

        // 1: route param varsa ondan, yoxdursa 2: URL-in 1-ci segmentindən
        $routeLocale = $request->route('locale');
        $segLocale   = $request->segment(1);

        $locale = in_array($routeLocale, $supported, true)
            ? $routeLocale
            : (in_array($segLocale, $supported, true) ? $segLocale : config('app.locale', 'en'));

        app()->setLocale($locale);
        \Carbon\Carbon::setLocale($locale);
        \Illuminate\Support\Facades\URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}

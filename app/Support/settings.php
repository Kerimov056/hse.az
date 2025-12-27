<?php

use App\Models\Setting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

if (! function_exists('setting')) {
    /**
     * setting('site.name'), setting('social.instagram'), setting('home.about.title')
     * Key boş qalarsa bütünləşdirilmiş array qaytarır.
     */
    function setting(?string $key = null, $default = null)
    {
        $merged = Cache::rememberForever('settings:merged', function () {
            $all = Setting::query()->get(['key', 'value']);
            $out = [];
            foreach ($all as $row) {
                Arr::set($out, $row->key, $row->value);
            }
            return $out;
        });

        return is_null($key) ? $merged : Arr::get($merged, $key, $default);
    }
}

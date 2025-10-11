<?php
// app/helpers.php  (composer.json-da "files"ə əlavə et)
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (! function_exists('setting')) {
    function setting(string $key, $default = null) {
        return Cache::remember("setting:$key", 3600, function() use ($key, $default) {
            $row = Setting::where('key',$key)->first();
            return $row?->value ?? $default;
        });
    }
}

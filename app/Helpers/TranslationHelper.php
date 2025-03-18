<?php

use Illuminate\Support\Facades\File;

if (! function_exists('loadJsonTranslations')) {

    function loadJsonTranslations($locale) {
        
        $path = resource_path("lang/{$locale}.json");

        if (File::exists($path)) {
            return json_decode(File::get($path), true);
        }

        return [];
    }
}

<?php

namespace App\Providers;

use Illuminate\Translation\Translator;
use Illuminate\Translation\FileLoader;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider {

    public function register() {

        $this->app->singleton('translator', function ($app) {
            
            $loader = new FileLoader(new Filesystem, resource_path('lang'));
            $locale = $app->getLocale();

            $translator = new Translator($loader, $locale);

            // Force le chargement des fichiers JSON
            $jsonTranslations = loadJsonTranslations($locale);

            foreach ($jsonTranslations as $key => $value) {
                Lang::addLines([$key => $value], $locale);
            }

            return $translator;
        });
    }

    public function boot()
    {
        Lang::setFallback(config('app.fallback_locale'));
    }
}

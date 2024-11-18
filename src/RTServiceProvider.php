<?php

namespace SamuelOlavo\LaravelRTBestpratical;

use Illuminate\Support\ServiceProvider;

class RTServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(RTService::class, function ($app) {
            return new RTService();
        });
    }

    public function boot()
    {
        // Publish configuration if needed
        $this->publishes([
            __DIR__.'/../config/rt.php' => config_path('rt.php'),
        ]);
    }
}


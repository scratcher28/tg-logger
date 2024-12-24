<?php

namespace ProgTime\TgLogger;

use Illuminate\Support\ServiceProvider;
use ProgTime\TgLogger\Commands\TgLoggerCreateTopics;

class TgLoggerServiceProvider extends ServiceProvider
{
    /**
     * Register the application's services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tg-logger.php', 'tg-logger');
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TgLoggerCreateTopics::class,
            ]);

            $this->publishes([
                __DIR__ . '/../config/tg-logger.php' => config_path('tg-logger.php'),
            ], 'config');
        }
    }
}

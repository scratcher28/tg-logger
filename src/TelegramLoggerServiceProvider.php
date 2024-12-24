<?php

namespace ProgTime\TgLogger;

use Illuminate\Support\ServiceProvider;
use ProgTime\TgLogger\Commands\TgLoggerCreateTopics;

class TelegramLoggerServiceProvider extends ServiceProvider
{
    /**
     * Register the application's services.
     */
    public function register()
    {

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
        }
    }
}

<?php

namespace TgLogger\TelegramLogger;

use Illuminate\Support\ServiceProvider;

class TgLoggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Публикация конфигурационного файла
        $this->publishes([
            __DIR__ . '/config/telegram-logger.php' => config_path('telegram-logger.php'),
        ], 'config');
    }

    public function register()
    {
        // Слияние конфигурации с пользовательской
        $this->mergeConfigFrom(__DIR__ . '/config/telegram-logger.php', 'telegram-logger');

        // Регистрация TelegramLogger как singleton
        $this->app->singleton('telegram.logger', function ($app) {
            return new TgLogger();
        });
    }
}

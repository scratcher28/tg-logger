# Telegram Logger for Laravel

A module for Laravel that allows you to send logs to Telegram.

## Description
This module allows you to send logs to a Telegram group, breaking them down by topic. You can describe the configuration for the basic log types or write your own logging levels.

## Installing the module
The installation is done using Composer:
```bash
composer require prog-time/tg-logger
```
   
## Configuring the module
1. Create a Telegram bot
2. Create a Telegram group and include "Topics" in it
3. Specify the variables in .environment
```php
TG_LOGGER_TOKEN="token_bot"
TG_LOGGER_CHAT_ID="id_group"
```
4. Add the created bot and grant it administrator rights
5. Create a configuration file **config/tg-logger.php** manually or using a command.
```php
php artisan vendor:publish --tag=config
```
6. In **config/tg-logger.php** specify the bot token, the ID of the created group, and describe the topics that need to be created.
```bash
return [
    'token' => env('TG_LOGGER_TOKEN'),
    'chat_id' => env('TG_LOGGER_CHAT_ID'),
    'topics' => [
        [
            'name' => 'Debug messages',
            'icon_color' => '9367192',
            'level' => 'debug',
        ],
        [
            'name' => 'Cron tasks',
            'icon_color' => '9367192',
            'level' => 'crone',
        ],
        [
            'name' => 'Errors',
            'icon_color' => '9367192',
            'level' => 'error, notice, warning, emergency',
        ]
  ]
];
```
7. Run the command to create themes in a group. After executing this command, the file **config/tg-logger.php** it will be overwritten and the topic IDs for each log type will be indicated in it.
```bash
php artisan tglogger:create-topics
```

## Sending any type of error
To catch all types of errors, you need to change the basic log handler in
the configuration file **config/logging.php** by specifying the module classes as handlers.

```angular2html
'channels' => [
        ...
        'telegram' => [
            'driver' => 'monolog',
            'handler' => ProgTime\TgLogger\TgHandler::class,
            'formatter' => ProgTime\TgLogger\TgFormatter::class,
            'level' => 'debug',
        ],
        ...
    ],
```
and in .env, change the **LOG_CHANNEL parameter**

```angular2html
LOG_CHANNEL=telegram
```

## Calling the module operation directly
To work with the module directly, you can use the following code.

```php
TgLogger::sendLog('Your message', 'level');
```

# Telegram Logger for Laravel

Модуль для Laravel, который позволяет отправлять логи
в Telegram.

## Описание
Данный модуль позволяем отправлять логи в Telegram группу
разбивая из по темам. Вы можете описать конфигурацию для базовых типов логов
или написать свои уровни логирования.

## Установка модуля
Установка производится с помощью Composer:
   ```bash
   composer require prog-time/tg-logger
   ```
   
## Настройка модуля
1. Создайте Telegram бота
2. Создайте Telegram группу и включите в ней "Темы"
3. Укажите переменные в .env
```php
TG_LOGGER_TOKEN="token_bot"
TG_LOGGER_CHAT_ID="id_group"
```
4. Добавьте созданного бота и выдайте ему права администратора
5. Создайте конфигурационный файл **config/tg-logger.php** в вашем проекте. Здесь укажите токен бота, ID созданной группы и опишите темы которые нужно создать.
```bash
<?php

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
6. Выполните команду для создания тем в группе. После выполнения данной команды, файл **config/tg-logger.php** перезапишется и в нём будут указаны ID топиков для каждого типа лога.
```bash
php artisan tglogger:create-topics
```

## Отправка любых типов ошибок
Для отлова всех типов ошибок вам необходимо изменить базовый обработчик логов в 
конфигурационном файле **config/logging.php**, указав в качестве обработчиков классы модуля.

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
И в .env изменить параметр **LOG_CHANNEL**

```angular2html
LOG_CHANNEL=telegram
```

## Вызов работы модуля напрямую
Для работы с модулем напрямую вы можете использовать следующий код.

```php
TgLogger::sendLog('Your message', 'level');
```

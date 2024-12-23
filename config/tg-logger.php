<?php

return [
    'token' => env('TG_LOGGER_TOKEN'),
    'chat_id' => env('TG_LOGGER_CHAT_ID'),
    'topics' => [
        [
            'name' => 'Errors',
            'icon_color' => '9367192',
            'level' => 'error, notice, warning, emergency',
        ]
    ]
];

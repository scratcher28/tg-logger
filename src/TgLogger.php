<?php

namespace TgLogger\TelegramLogger;

use GuzzleHttp\Client;

class TgLogger
{
    protected $botToken;
    protected $chatId;
    protected $client;

    public function __construct()
    {
        $this->botToken = config('telegram-logger.bot_token');
        $this->chatId = config('telegram-logger.chat_id');
        $this->client = new Client();
    }

    public function sendLog(string $message): void
    {
        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

        $this->client->post($url, [
            'form_params' => [
                'chat_id' => $this->chatId,
                'text' => $message,
            ],
        ]);
    }
}

<?php

namespace TgLoggers\TelegramLogger;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class TgLoggerChannel
{
    public function __invoke(array $config)
    {
        return new Logger('telegram', [new TgHandler()]);
    }
}

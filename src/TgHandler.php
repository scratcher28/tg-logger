<?php

namespace ProgTime\TgLogger;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class TgHandler extends AbstractProcessingHandler
{
    protected function write(LogRecord $record): void
    {
        $levelName = strtolower($record->level->name);
        TgLogger::sendLog($record['formatted'], $levelName);
    }
}

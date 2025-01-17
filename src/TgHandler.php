<?php

namespace ProgTime\TgLogger;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class TgHandler extends AbstractProcessingHandler
{
    protected function write($record): void
    {
        // If it's an object, convert it to an array for compatibility
        if ($record instanceof LogRecord) {
            $record = $record->toArray();
        }

        $levelName = strtolower($record['level_name']);
        TgLogger::sendLog($record['formatted'], $levelName);
    }
}

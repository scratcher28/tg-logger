<?php

namespace TgLogger\TelegramLogger;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class TgHandler extends AbstractProcessingHandler
{
    protected $logger;

    public function __construct($level = Logger::ERROR, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
        $this->logger = app('telegram.logger');
    }

    protected function write(LogRecord $record): void
    {
        $this->logger->sendLog($record['formatted']);
    }
}

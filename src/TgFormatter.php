<?php

namespace ProgTime\TgLogger;

use Monolog\Formatter\LineFormatter;

class TgFormatter extends LineFormatter
{
    public function __construct()
    {
        $format = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
        parent::__construct($format, null, true, true);
    }
}

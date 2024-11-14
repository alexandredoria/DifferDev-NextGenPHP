<?php

namespace MyLog\Logger;

class Logger
{
    public function __construct(private LoggerInterface $fileLogger)
    {

    }

    public function log(LogLevel $level, string $message, array $data): void
    {
        $this->fileLogger->log($level->value, $message, $data);
    }
}

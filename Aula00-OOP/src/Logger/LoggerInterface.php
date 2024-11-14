<?php

namespace MyLog\Logger;

interface LoggerInterface
{
    public function log(string $logLevel, string $logMessage, array $data): void;
}
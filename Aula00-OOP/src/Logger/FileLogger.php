<?php

namespace MyLog\Logger;

class FileLogger implements LoggerInterface
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function log(string $logLevel, string $logMessage, array $logData): void
    {
        $logFormatedMessage = sprintf(
            "%s | %s: [%s] [%s]%s",
            date('Y-m-d H:i:s'),
            $logLevel,
            $logMessage,
            json_encode($logData),
            PHP_EOL
        );
        file_put_contents($this->filePath, $logFormatedMessage, FILE_APPEND);
    }
}

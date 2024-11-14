<?php

use MyLog\Logger\Logger;
use MyLog\Logger\FileLogger;
use MyLog\Logger\LogLevel;

require __DIR__ . '/vendor/autoload.php';

$logger = new Logger(new FileLogger('./logs.txt'));

$logger->log(level: LogLevel::alert, message: 'Message 1', data: ['data1' => 1, 'data2' => 2]);
$logger->log(level: LogLevel::danger, message: 'Message 3', data: ['data3' => 1, 'data4' => 2]);
$logger->log(level: LogLevel::log, message: 'Message 2', data: ['data5' => 1, 'data6' => 2]);

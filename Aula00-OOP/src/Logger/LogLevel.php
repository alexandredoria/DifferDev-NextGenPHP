<?php

namespace Mylog\Logger;

enum LogLevel: string
{
    case alert = 'alert';
    case danger = 'danger';
    case log = 'log';
}
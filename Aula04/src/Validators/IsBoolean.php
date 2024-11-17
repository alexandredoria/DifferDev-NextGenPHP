<?php

namespace DifferDev\Validators;

use DifferDev\Interfaces\ValidatorInterface;

class IsBoolean implements ValidatorInterface
{
    public function execute(mixed $value): bool
    {
        return (bool) preg_match('/^(true|false|1|0)$/i', $value);
    }
}

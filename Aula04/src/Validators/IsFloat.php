<?php

namespace DifferDev\Validators;

use DifferDev\Interfaces\ValidatorInterface;

class IsFloat implements ValidatorInterface
{
    public function execute(mixed $value): bool
    {
        return 1 === preg_match('/^[-+]?\d*\.\d+$/', $value);
    }
}


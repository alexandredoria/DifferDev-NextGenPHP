<?php

namespace DifferDev\Validators;

use DifferDev\Interfaces\ValidatorInterface;

class IsEven implements ValidatorInterface
{
    public function execute(mixed $value): bool
    {
        if (!is_numeric($value))
        {
            throw new \InvalidArgumentException("'$value' is not a number!");
        }

        if (0 === preg_match('/^-?\d+$/', $value))
        {
            throw new \InvalidArgumentException("'$value' is not an integer!");
        }

        return !($value % 2);
    }
}


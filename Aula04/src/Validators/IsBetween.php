<?php

namespace DifferDev\Validators;

use DifferDev\Interfaces\ValidatorInterface;

class IsBetween implements ValidatorInterface
{
    public function __construct(public string|int|float $min, public string|int|float $max)
    {
        $this->checkNumeric($min);
        $this->checkNumeric($max);
    }

    public function execute(mixed $value): bool
    {
        $this->checkNumeric($value);

        return $this->min <= $value && $value <= $this->max;
    }

    private function checkNumeric($value)
    {
        if (!is_numeric($value))
        {
            throw new \InvalidArgumentException("'$value' is not a number!");
        }
    }
}


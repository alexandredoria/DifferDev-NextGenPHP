<?php

namespace DifferDev\Validators;

use DifferDev\Interfaces\ValidatorInterface;

class IsGreaterThan implements ValidatorInterface
{
    public function __construct(public string|int|float $comparison)
    {
        $this->checkNumeric($comparison);
    }

    public function execute(mixed $value): bool
    {
        $this->checkNumeric($value);

        return $value > $this->comparison;
    }

    private function checkNumeric($value)
    {
        if (!is_numeric($value))
        {
            throw new \InvalidArgumentException("'$value' is not a number!");
        }
    }
}


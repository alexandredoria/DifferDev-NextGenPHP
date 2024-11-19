<?php

namespace DifferDev;

use DifferDev\Interfaces\ValidatorInterface;
use DifferDev\Validators;
use InvalidArgumentException;

class Validator
{
    public array $validators = [];
    public static function validateFloat(string $floatValue): bool
    {
        $validator = new Validators\IsFloat;
        return $validator->execute($floatValue);
    }

    public static function validateInteger(string $intValue): bool
    {
        $validator = new Validators\IsInteger;
        return $validator->execute($intValue);
    }

    public static function validateBoolean(string $booleanValue): bool
    {
        $validator = new Validators\IsBoolean;
        return $validator->execute($booleanValue);
    }

    public static function validateGreaterThan(int|float|string $number, int|float|string $compared): bool
    {
        $validator = new Validators\IsGreaterThan($compared);
        return $validator->execute($number);
    }

    public static function validateBetween(int|float|string $number, int|float|string $min, int|float|string $max): bool
    {
        $validator = new Validators\IsBetween($min, $max);
        return $validator->execute($number);
    }

    public static function validateEven(string $value): bool
    {
        $validator = new Validators\IsEven;
        return $validator->execute($value);
    }
    
    public function addValidation(ValidatorInterface $validator): self
    {
        $this->validators[] = $validator;
        return $this;
    }

    public function validate(mixed $value): bool
    {
        foreach ($this->validators as $validator) {
            if (!$validator->execute($value)) {
                return false;
            }
        }

        return true;
    }    
}

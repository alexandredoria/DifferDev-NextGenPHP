<?php

namespace DifferDev\Interfaces;

interface ValidatorInterface
{
    public function execute(mixed $value): bool;
}
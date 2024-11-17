<?php

use DifferDev\Validators\IsBoolean;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(IsBoolean::class)]
final class IsBooleanTest extends \PHPUnit\Framework\TestCase
{
    public static function positiveIsBooleanDataProvider(): array
    {
        return [
            ['true'],
            ['false'],
            ['TRUE'],
            ['FALSE'],
            ['1'],
            ['0'],
        ];
    }

    public static function negativeIsBooleanDataProvider(): array
    {
        return [
            ['true.'],
            ['false.'],
            ['TRUE.'],
            ['FALSE.'],
            ['1.'],
            ['0.'],
            ['.true'],
            ['.false'],
            ['.TRUE'],
            ['.FALSE'],
            ['.1'],
            ['.'],
        ];
    }

    #[DataProvider('positiveIsBooleanDataProvider')]
    public function testShouldValidateIsBoolean(string|int|bool $value): void
    {
        $validator = new IsBoolean;
        $result = $validator->execute($value);
        $this->assertTrue($result);
    }

    #[DataProvider('negativeIsBooleanDataProvider')]
    public function testShouldValidateIsNotBoolean(string|int|bool $value): void
    {
        $validator = new IsBoolean;
        $result = $validator->execute($value);
        $this->assertFalse($result);
    }
}

<?php

use DifferDev\Validators\IsInteger;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(IsInteger::class)]
final class IsIntegerTest extends \PHPUnit\Framework\TestCase
{
    public static function positiveIsIntegerDataProvider(): array
    {
        return [
            ['1'],
            ['0'],
            ['-2'],
        ];
    }

    public static function negativeIsIntegerDataProvider(): array
    {
        return [
            ['A'],
            ['123.22'],
            ['-0.5'],
        ];
    }

    #[DataProvider('positiveIsIntegerDataProvider')]
    public function testShouldValidateIsInteger(string $value): void
    {
        $validator = new IsInteger;
        $result = $validator->execute($value);
        $this->assertTrue($result);
    }

    #[DataProvider('negativeIsIntegerDataProvider')]
    public function testShouldValidateIsNotInteger(string $value): void
    {
        $validator = new IsInteger;
        $result = $validator->execute($value);
        $this->assertFalse($result);
    }
}

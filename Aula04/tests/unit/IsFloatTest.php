<?php

use DifferDev\Validators\IsFloat;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(IsFloat::class)]
final class IsFloatTest extends \PHPUnit\Framework\TestCase
{
    public static function positiveIsFloatDataProvider(): array
    {
        return [
            ['1.0'],
            ['0.5'],
            ['123.22'],
            ['-1.2'],
        ];
    }

    public static function negativeIsFloatDataProvider(): array
    {
        return [
            ['-1'],
            ['1'],
        ];
    }

    #[DataProvider('positiveIsFloatDataProvider')]
    public function testShouldValidateIsFloat($value): void
    {
        $validator = new IsFloat;
        $result = $validator->execute($value);
        $this->assertTrue($result);
    }

    #[DataProvider('negativeIsFloatDataProvider')]
    public function testShouldValidateIsNotFloat($value): void
    {
        $validator = new IsFloat;
        $result = $validator->execute($value);
        $this->assertFalse($result);
    }
}

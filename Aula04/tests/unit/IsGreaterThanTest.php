<?php

use DifferDev\Validators\IsGreaterThan;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(IsGreaterThan::class)]
final class IsGreaterThanTest extends \PHPUnit\Framework\TestCase
{
    public static function positiveIsGreaterThanDataProvider(): array
    {
        return [
            ['1.0', '0.5'],
            ['0.5', '0'],
            ['123.22', '-100.5'],
            ['-1.2', '-1.8'],
        ];
    }

    public static function negativeIsGreaterThanDataProvider(): array
    {
        return [
            ['A', 'A'],
            ['A', '1'],
            ['-1', 'A'],
            [NULL, '1'],
        ];
    }

    #[DataProvider('positiveIsGreaterThanDataProvider')]
    public function testShouldValidateIsGreaterThan($value, $comparison): void
    {
        $validator = new IsGreaterThan($comparison);
        $result = $validator->execute($value);
        $this->assertTrue($result);
    }

    #[DataProvider('negativeIsGreaterThanDataProvider')]
    public function testShouldThrowAnException($value, $comparison): void
    {
        $this->expectException(InvalidArgumentException::class);
        $validator = new IsGreaterThan($comparison);
        $result = $validator->execute($value);
    }
}

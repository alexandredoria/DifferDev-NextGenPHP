<?php

use DifferDev\Validators\IsBetween;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(IsBetween::class)]
final class IsBetweenTest extends \PHPUnit\Framework\TestCase
{
    public static function positiveIsBetweenDataProvider(): array
    {
        return [
            ['1.0', '0.5', '2.0'],
            ['0.5', '0', '1'],
            ['123.22', '-100.5', '124'],
            ['-1.2', '-1.8', '-1'],
        ];
    }

    public static function negativeIsBetweenDataProvider(): array
    {
        return [
            ['A', 'A', 'A'],
            ['A', '1', '1'],
            ['-1', 'A', '1'],
            [NULL, '1', '1'],
        ];
    }

    #[DataProvider('positiveIsBetweenDataProvider')]
    public function testShouldValidateIsBetween($value, $min, $max): void
    {
        $validator = new IsBetween($min, $max);
        $result = $validator->execute($value);
        $this->assertTrue($result);
    }

    #[DataProvider('negativeIsBetweenDataProvider')]
    public function testShouldThrowAnException($value, $min, $max): void
    {
        $this->expectException(InvalidArgumentException::class);
        $validator = new IsBetween($min, $max);
        $result = $validator->execute($value);
    }
}

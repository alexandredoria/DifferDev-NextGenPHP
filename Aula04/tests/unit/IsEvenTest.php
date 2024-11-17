<?php

use DifferDev\Validators\IsEven;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(IsEven::class)]
final class IsEvenTest extends \PHPUnit\Framework\TestCase
{
    public static function positiveIsEvenDataProvider(): array
    {
        return [
            ['2', true],
            ['0', true],
            ['8', true],
            ['10', true],
            ['1', false],
            ['3', false],
            ['55', false],
        ];
    }

    public static function negativeIsEvenDataProvider(): array
    {
        return [
            ['A'],
            ['1.0'],
            ['-1.5'],
            [NULL],
        ];
    }

    #[DataProvider('positiveIsEvenDataProvider')]
    public function testShouldValidateIsEven($value, $expected): void
    {
        $validator = new IsEven;
        $result = $validator->execute($value);
        $this->assertEquals($result, $expected);
    }

    #[DataProvider('negativeIsEvenDataProvider')]
    public function testShouldThrowAnException($value): void
    {
        $this->expectException(InvalidArgumentException::class);
        $validator = new IsEven;
        $result = $validator->execute($value);
    }
}

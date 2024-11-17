<?php

use DifferDev\Validator;
use DifferDev\Validators;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(Validator::class)]
#[CoversClass(Validators\IsInteger::class)]
#[CoversClass(Validators\IsGreaterThan::class)]
#[CoversClass(Validators\IsEven::class)]
#[CoversClass(Validators\IsBetween::class)]
#[CoversClass(Validators\IsFloat::class)]
#[CoversClass(Validators\IsBoolean::class)]
final class ValidatorTest extends \PHPUnit\Framework\TestCase
{
    public static function positiveDataProvider(): array
    {
        return [
            ['400', true],
            ['304', true],
            ['301', false],
            ['18', false],
            ['21', false],
        ];
    }

    #[DataProvider('positiveDataProvider')]
    public function testClassValidatorShouldValidateMultipleValidations($value, $expected): void
    {
        $result1 = Validator::validateInteger($value);
        $result2 = Validator::validateGreaterThan($value, 200);
        $result3 = Validator::validateEven($value);
        $result4 = Validator::validateBetween($value, 200, 400);
        $result5 = Validator::validateFloat($value);
        $result6 = Validator::validateBoolean($value);

        $this->assertEquals(($result1 && $result2 && $result3 && $result4 && !$result5 && !$result6) , $expected);
    }

    #[DataProvider('positiveDataProvider')]
    public function testClassValidatorShouldAggregateMultipleValidations($value, $expected): void
    {
        $validator = new Validator;

        $validationGroup = $validator->addValidation(Validators\IsInteger::class)
                                     ->addValidation(Validators\IsGreaterThan::class, 200)
                                     ->addValidation(Validators\IsBetween::class, 200, 400)
                                     ->addValidation(Validators\IsEven::class);

        $result = $validationGroup->validate($value);
        $this->assertEquals($result, $expected);
    }

    public function testClassValidatorShouldThrowAnException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $value = date('Y-m-d');
        $validator = new Validator;

        $validationGroup = $validator->addValidation(DateTime::class);
        $result = $validationGroup->validate($value);
    }
}

<?php

namespace Unit\Domain\Validations;

use Core\Domain\Exceptions\EntityValidationException;
use Core\Domain\Validations\DomainValidation;
use PHPUnit\Framework\TestCase;
use Throwable;

class DomainValidationUnitTest extends TestCase
{
    public function testMustReturnExceptionIfValueGreaterThanMaxLength()
    {
        try {
            $value = random_bytes(256);
            
            DomainValidation::greaterThan($value);
            
            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(
                EntityValidationException::class,
                $th,
                'The value must not be greater than 255 characters.'
            );
        }
    }

    public function testMustReturnExceptionIfValueGreaterThanMaxLengthAndSpecificMessage()
    {
        try {
            $value = random_bytes(256);
            $message = 'Description must not be greater than 255 characters.';

            DomainValidation::greaterThan($value, $message);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(
                EntityValidationException::class,
                $th,
                'Description must not be greater than 255 characters.'
            );
        }
    }

    public function testMustReturnExceptionIfValueLowerThanMinLength()
    {
        try {
            $value = random_bytes(1);

            DomainValidation::lowerThan($value);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(
                EntityValidationException::class,
                $th,
                'The value must not be lower than 2 characters.'
            );
        }
    }

    public function testMustReturnExceptionIfValueLowerThanMinLengthAndSpecificMessage()
    {
        try {
            $value = random_bytes(1);
            $message = 'Description must not be lower than 2 characters.';

            DomainValidation::lowerThan($value, $message);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(
                EntityValidationException::class,
                $th,
                'Description must not be lower than 2 characters.'
            );
        }
    }
}
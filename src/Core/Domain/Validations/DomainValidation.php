<?php

namespace Core\Domain\Validations;

use Core\Domain\Exceptions\EntityValidationException;

class DomainValidation
{
    public static function greaterThan(
        string $value,
        string $message = null,
        int $maxLength = 255
    ): EntityValidationException|null {
        if (strlen($value) > $maxLength) {
            throw new EntityValidationException(
                $message ?? "The value must not be greater than $maxLength characters."
            );
        }
        
        return null;
    }

    public static function lowerThan(
        string $value,
        string $message = null,
        int $minLength = 2
    ): EntityValidationException|null {
        if (strlen($value) < $minLength) {
            throw new EntityValidationException(
                $message ?? "The value must not be lower than $minLength characters."
            );
        }
        
        return null;
    }
}
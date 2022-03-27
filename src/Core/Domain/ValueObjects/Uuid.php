<?php

namespace Core\Domain\ValueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    public function __construct(
        protected string $value
    ) {
        $this->ensureIsValid($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function uuid4(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    private function ensureIsValid(string $id): InvalidArgumentException|null
    {
        if (! RamseyUuid::isValid($id)) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow the value <%s>.', static::class, $id)
            );
        }

        return null;
    }
}

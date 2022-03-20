<?php

namespace Core\Domain\Entities;

use Core\Domain\Entities\Traits\MagicsMethodsTrait;
use Core\Domain\Exceptions\EntityValidationException;
use Core\Domain\Validations\DomainValidation;
use InvalidArgumentException;

class Team
{
    use MagicsMethodsTrait;

    public function __construct (
        protected string $description,
        protected bool $isActive = true,
        protected string $id = '',
    ) {
        $this->validate();
    }

    public function disable(): void
    {
        $this->isActive = false;
    }

    public function enable(): void
    {
        $this->isActive = true;
    }

    public function update(string $description): void
    {
        $this->description = $description;
        
        $this->validate();
    }

    public function validate()
    {
        DomainValidation::lowerThan($this->description);
        DomainValidation::greaterThan($this->description);
        
        if (
            ! $this->id &&
            ! $this->isActive
        ) {
            throw new InvalidArgumentException(
                'Cannot create a team with isActive property false, just update it.'
            );
        }
    }
}
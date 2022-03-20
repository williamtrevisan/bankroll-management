<?php

namespace Core\Domain\Entities;

use Core\Domain\Entities\Traits\MagicsMethodsTrait;
use Core\Domain\Validations\DomainValidation;
use Core\Domain\ValuesObjects\Uuid;
use InvalidArgumentException;

class Team
{
    use MagicsMethodsTrait;

    public function __construct (
        protected string $description,
        protected bool $isActive = true,
        protected Uuid|string $id = '',
    ) {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::uuid4();
        
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
    }
}
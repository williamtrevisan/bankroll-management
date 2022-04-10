<?php

namespace Core\Domain\Entities;

use Core\Domain\Entities\Traits\MagicsMethodsTrait;
use Core\Domain\Validations\DomainValidation;
use Core\Domain\ValueObjects\Uuid;
use DateTime;

class Team
{
    use MagicsMethodsTrait;

    public function __construct (
        protected Uuid|string $id = '',
        protected string $description = '',
        protected bool $isActive = true,
        protected DateTime|string $createdAt = '',
    ) {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::uuid4();
        $this->createdAt =
            $this->createdAt
                ? new DateTime($this->createdAt)
                : new DateTime();

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

    private function validate(): void
    {
        DomainValidation::lowerThan($this->description);
        DomainValidation::greaterThan($this->description);
    }
}

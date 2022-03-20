<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\MagicsMethodsTrait;
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
        $this->validate();

        $this->description = $description;
    }

    public function validate()
    {
        if (
            ! $this->id &&
            ! $this->isActive
        ) {
            throw new InvalidArgumentException('Sorry, it\'s not possible to create a team with isActive property false, just update it.');
        }
    }
}
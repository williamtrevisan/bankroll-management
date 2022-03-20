<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\MagicsMethodsTrait;

class Team
{
    use MagicsMethodsTrait;

    public function __construct (
        protected string $description,
        protected bool $isActive = true,
        protected string $id = '',
    ) {}
}
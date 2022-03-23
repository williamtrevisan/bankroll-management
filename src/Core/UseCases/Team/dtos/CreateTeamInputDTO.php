<?php

namespace Core\UseCases\Team\dtos;

class CreateTeamInputDTO
{
    public function __construct(
        public string $description,
        public bool $isActive = true
    ) {}
}
<?php

namespace Core\UseCases\Team\dtos\Create;

class CreateTeamInputDTO
{
    public function __construct(
        public string $name,
        public bool $isActive = true
    ) {}
}

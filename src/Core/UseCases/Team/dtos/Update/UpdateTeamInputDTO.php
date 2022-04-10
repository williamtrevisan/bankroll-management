<?php

namespace Core\UseCases\Team\dtos\Update;

class UpdateTeamInputDTO
{
    public function __construct(
        public string $id,
        public string $description,
        public bool $is_active = true
    ) {}
}

<?php

namespace Core\UseCases\Team\dtos;

class CreateTeamOutputDTO
{
    public function __construct(
        public string $id,
        public string $description,
        public bool $is_active = true,
        public string $created_at = '',
    ) {}
}

<?php

namespace Core\UseCases\Team\dtos\Delete;

class DeleteTeamOutputDTO
{
    public function __construct(
        public bool $success
    ) {}
}

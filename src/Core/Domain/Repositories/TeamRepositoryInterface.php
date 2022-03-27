<?php

namespace Core\Domain\Repositories;

use Core\Domain\Entities\Team;

interface TeamRepositoryInterface
{
    public function create(Team $team): Team;
}

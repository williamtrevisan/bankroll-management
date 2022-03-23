<?php

namespace Core\Domain\Repositories;

use Core\Domain\Entities\Team;

interface TeamRepositoryInterface
{
    public function save(Team $team): Team;
}
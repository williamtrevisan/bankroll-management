<?php

namespace Core\Domain\Repositories;

use Core\Domain\Entities\Team;

interface TeamRepositoryInterface
{
    public function create(Team $team): Team;
    public function findByPk(string $teamId): Team;
    public function update(Team $team): Team;
    public function delete(string $teamId): bool;
}

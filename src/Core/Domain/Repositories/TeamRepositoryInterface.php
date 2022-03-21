<?php

namespace Core\Domain\Repositories;

use Core\Domain\Entities\Team;

interface TeamRepositoryInterface
{
    public function insert(Team $team): Team;
    public function findById(string $id): Team;
    public function findAll(string $filter = '', string $order = 'DESC'): array;
    public function paginate(
        string $filter = '',
        string $order = 'DESC',
        int $page = 1,
        int $totalPerPage = 12
    ): array;
    public function update(Team $team): Team;
    public function delete(string $id): bool;
    public function toTeam(string $id): bool;
}
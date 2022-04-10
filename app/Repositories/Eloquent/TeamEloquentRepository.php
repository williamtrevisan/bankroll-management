<?php

namespace App\Repositories\Eloquent;

use App\Models\Team as TeamModel;
use Core\Domain\Entities\Team as TeamEntity;
use Core\Domain\Exceptions\NotFoundException;
use Core\Domain\Repositories\TeamRepositoryInterface;

class TeamEloquentRepository implements TeamRepositoryInterface
{
    public function __construct(
        protected TeamModel $teamModel
    ) {}

    public function create(TeamEntity $team): TeamEntity
    {
        $team = $this->teamModel->create([
            'id' => $team->id(),
            'description' => $team->description,
            'is_active' => $team->isActive,
            'created_at' => $team->createdAt(),
        ]);

        return $this->toTeam($team);
    }

    public function findByPk(string $teamId): TeamEntity
    {
        $team = $this->teamModel->find($teamId);
        if (! $team) {
            throw new NotFoundException('Team not found');
        }

        return $this->toTeam($team);
    }

    public function update(TeamEntity $team): TeamEntity
    {
        $databaseTeam = $this->teamModel->find($team->id());
        if (! $databaseTeam) {
            throw new NotFoundException('Team not found');
        }

        $databaseTeam->update([
            'description' => $team->description,
            'is_active' => $team->isActive,
        ]);
        $databaseTeam->refresh();

        return $this->toTeam($databaseTeam);
    }

    public function delete(string $teamId): bool
    {
        $databaseTeam = $this->teamModel->find($teamId);
        if (! $databaseTeam) {
            throw new NotFoundException('Team not found');
        }

        return $databaseTeam->delete();
    }

    private function toTeam(object $object): TeamEntity
    {
        $teamEntity = new TeamEntity(
            id: $object->id,
            description: $object->description,
        );
        $object->is_active ? $teamEntity->enable() : $teamEntity->disable();

        return $teamEntity;
    }
}

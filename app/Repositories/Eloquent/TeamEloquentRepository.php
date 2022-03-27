<?php

namespace App\Repositories\Eloquent;

use App\Models\Team as TeamModel;
use Core\Domain\Entities\Team as TeamEntity;
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

    private function toTeam(object $object): TeamEntity
    {
        $teamEntity = new TeamEntity(
            description: $object->description,
            id: $object->id,
        );
        ((bool) $object->is_active) ? $teamEntity->enable() : $teamEntity->disable();

        return $teamEntity;
    }
}

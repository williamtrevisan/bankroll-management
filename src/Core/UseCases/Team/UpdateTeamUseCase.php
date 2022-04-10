<?php

namespace Core\UseCases\Team;

use Core\Domain\Repositories\TeamRepositoryInterface;
use Core\UseCases\Team\dtos\Update\UpdateTeamInputDTO;
use Core\UseCases\Team\dtos\TeamOutputDTO;

class UpdateTeamUseCase
{
    public function __construct(
        protected readonly TeamRepositoryInterface $teamRepository
    ) {}

    public function execute(UpdateTeamInputDTO $input): TeamOutputDTO
    {
        $team = $this->teamRepository->findByPk($input->id);
        $team->update(
            description: $input->description ?? $team->description
        );

        $teamUpdated = $this->teamRepository->update($team);

        return new TeamOutputDTO(
            id: $teamUpdated->id,
            description: $teamUpdated->description,
            is_active: $teamUpdated->isActive,
            created_at: $teamUpdated->createdAt()
        );
    }
}

<?php

namespace Core\UseCases\Team;

use Core\Domain\Repositories\TeamRepositoryInterface;
use Core\UseCases\Team\dtos\TeamInputDTO;
use Core\UseCases\Team\dtos\TeamOutputDTO;

class ListTeamUseCase
{
    public function __construct(
        protected readonly TeamRepositoryInterface $teamRepository
    ) {}

    public function execute(TeamInputDTO $input): TeamOutputDTO
    {
        $team = $this->teamRepository->findByPk($input->id);

        return new TeamOutputDTO(
            id: $team->id(),
            description: $team->description,
            is_active: $team->isActive,
            created_at: $team->createdAt(),
        );
    }
}

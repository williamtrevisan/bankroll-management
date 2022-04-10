<?php

namespace Core\UseCases\Team;

use Core\Domain\Entities\Team;
use Core\Domain\Repositories\TeamRepositoryInterface;
use Core\UseCases\Team\dtos\Create\CreateTeamInputDTO;
use Core\UseCases\Team\dtos\TeamOutputDTO;

class CreateTeamUseCase
{
    public function __construct(
       protected readonly TeamRepositoryInterface $teamRepository
    ) {}

    public function execute(CreateTeamInputDTO $input): TeamOutputDTO
    {
        $data = new Team(
            id: '',
            description: $input->description,
            isActive: $input->isActive,
        );

        $team = $this->teamRepository->create($data);

        return new TeamOutputDTO(
            id: $team->id(),
            description: $team->description,
            is_active: $team->isActive,
            created_at: $team->createdAt(),
        );
    }
}

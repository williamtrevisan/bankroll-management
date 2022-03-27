<?php

namespace Core\UseCases\Team;

use Core\Domain\Entities\Team;
use Core\Domain\Repositories\TeamRepositoryInterface;
use Core\UseCases\Team\dtos\CreateTeamInputDTO;
use Core\UseCases\Team\dtos\CreateTeamOutputDTO;

class CreateTeamUseCase
{
    public function __construct(
       protected readonly TeamRepositoryInterface $teamRepository
    ) {}

    public function execute(CreateTeamInputDTO $input): CreateTeamOutputDTO
    {
        $data = new Team(
            description: $input->description,
            isActive: $input->isActive,
        );

        $team = $this->teamRepository->create($data);

        return new CreateTeamOutputDTO(
            id: $team->id(),
            description: $team->description,
            is_active: $team->isActive,
        );
    }
}

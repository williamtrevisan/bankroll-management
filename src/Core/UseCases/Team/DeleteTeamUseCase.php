<?php

namespace Core\UseCases\Team;

use Core\Domain\Repositories\TeamRepositoryInterface;
use Core\UseCases\Team\dtos\TeamInputDTO;
use Core\UseCases\Team\dtos\Delete\DeleteTeamOutputDTO;

class DeleteTeamUseCase
{
    public function __construct(
        protected readonly TeamRepositoryInterface $teamRepository
    ) {}

    public function execute(TeamInputDTO $input): DeleteTeamOutputDTO
    {
        $delete = $this->teamRepository->delete($input->id);

        return new DeleteTeamOutputDTO(
            success: $delete
        );
    }
}

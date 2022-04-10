<?php

namespace Tests\Feature\Core\UseCases\Team;

use App\Models\Team as TeamModel;
use App\Repositories\Eloquent\TeamEloquentRepository;
use Core\UseCases\Team\DeleteTeamUseCase;
use Core\UseCases\Team\dtos\Delete\DeleteTeamOutputDTO;
use Core\UseCases\Team\dtos\TeamInputDTO;
use Tests\TestCase;

class DeleteTeamUseCaseTest extends TestCase
{
    public function testShouldBeAbleToUpdateATeam()
    {
        $databaseTeam = TeamModel::factory()->create();
        $teamRepository = new TeamEloquentRepository(new TeamModel());
        $teamInputDTO = new TeamInputDTO(
            id: $databaseTeam->id
        );

        $deleteTeamUseCase = new DeleteTeamUseCase($teamRepository);
        $response = $deleteTeamUseCase->execute($teamInputDTO);

        $this->assertInstanceOf(DeleteTeamOutputDTO::class, $response);
        $this->assertTrue($response->success);
        $this->assertSoftDeleted($databaseTeam);
    }
}

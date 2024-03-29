<?php

namespace Tests\Feature\Core\UseCases\Team;

use App\Models\Team as TeamModel;
use App\Repositories\Eloquent\TeamEloquentRepository;
use Core\UseCases\Team\dtos\TeamOutputDTO;
use Core\UseCases\Team\dtos\Update\UpdateTeamInputDTO;
use Core\UseCases\Team\UpdateTeamUseCase;
use Tests\TestCase;

class UpdateTeamUseCaseTest extends TestCase
{
    public function testShouldBeAbleToUpdateATeam()
    {
        $databaseTeam = TeamModel::factory()->create();
        $teamRepository = new TeamEloquentRepository(new TeamModel());
        $updateTeamInputDTO = new UpdateTeamInputDTO(
            id: $databaseTeam->id,
            name: 'Updated name'
        );

        $updateTeamUseCase = new UpdateTeamUseCase($teamRepository);
        $response = $updateTeamUseCase->execute($updateTeamInputDTO);

        $this->assertInstanceOf(TeamOutputDTO::class, $response);
        $this->assertEquals('Updated name', $response->name);
        $this->assertDatabaseHas('teams', ['name' => $response->name]);
    }
}

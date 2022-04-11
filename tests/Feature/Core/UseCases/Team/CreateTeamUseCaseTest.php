<?php

namespace Tests\Feature\Core\UseCases\Team;

use App\Models\Team as TeamModel;
use App\Repositories\Eloquent\TeamEloquentRepository;
use Core\UseCases\Team\CreateTeamUseCase;
use Core\UseCases\Team\dtos\Create\CreateTeamInputDTO;
use Core\UseCases\Team\dtos\TeamOutputDTO;
use Tests\TestCase;

class CreateTeamUseCaseTest extends TestCase
{
    public function testShouldBeAbleToCreateANewTeam()
    {
        $teamEloquentRepository = new TeamEloquentRepository(new TeamModel());
        $createTeamInputDTO = new CreateTeamInputDTO('Internacional');

        $createTeamUseCase = new CreateTeamUseCase($teamEloquentRepository);
        $response = $createTeamUseCase->execute($createTeamInputDTO);

        $this->assertInstanceOf(TeamOutputDTO::class, $response);
        $this->assertEquals('Internacional', $response->name);
        $this->assertNotEmpty($response->id);
        $this->assertTrue($response->is_active);
        $this->assertDatabaseHas('teams', ['id' => $response->id]);
    }
}

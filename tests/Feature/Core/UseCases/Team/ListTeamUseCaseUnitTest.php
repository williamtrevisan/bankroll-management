<?php

namespace Tests\Feature\Core\UseCases\Team;

use App\Models\Team;
use App\Repositories\Eloquent\TeamEloquentRepository;
use Core\UseCases\Team\dtos\TeamInputDTO;
use Core\UseCases\Team\ListTeamUseCase;
use Tests\TestCase;

class ListTeamUseCaseUnitTest extends TestCase
{
    public function testShouldBeAbleToListATeam()
    {
        $databaseTeam = Team::factory()->create();
        $teamRepository = new TeamEloquentRepository(new Team());
        $teamInputDTO = new TeamInputDTO(id: $databaseTeam->id);

        $listTeamUseCase = new ListTeamUseCase($teamRepository);
        $response = $listTeamUseCase->execute($teamInputDTO);

        $this->assertEquals($databaseTeam->id, $response->id);
        $this->assertEquals($databaseTeam->description, $response->description);
    }
}

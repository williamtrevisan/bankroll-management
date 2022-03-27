<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Team as TeamModel;
use App\Repositories\Eloquent\TeamEloquentRepository;
use Core\Domain\Entities\Team as TeamEntity;
use Core\Domain\Repositories\TeamRepositoryInterface;
use Tests\TestCase;

class TeamEloquentRepositoryIntegrationTest extends TestCase
{
    public function testShouldBeAbleToCreateANewTeam()
    {
        $teamEloquentRepository = new TeamEloquentRepository(new TeamModel());
        $teamEntity = new TeamEntity(
            description: 'Internacional',
        );

        $response = $teamEloquentRepository->create($teamEntity);

        $this->assertInstanceOf(TeamRepositoryInterface::class, $teamEloquentRepository);
        $this->assertInstanceOf(TeamEntity::class, $response);
        $this->assertDatabaseHas('teams', ['description' => $teamEntity->description]);
    }
}

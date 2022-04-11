<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Team as TeamModel;
use App\Repositories\Eloquent\TeamEloquentRepository;
use Core\Domain\Entities\Team as TeamEntity;
use Core\Domain\Exceptions\NotFoundException;
use Core\Domain\Repositories\TeamRepositoryInterface;
use Tests\TestCase;
use Throwable;

class TeamEloquentRepositoryTest extends TestCase
{
    protected $teamEloquentRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teamEloquentRepository = new TeamEloquentRepository(new TeamModel());
    }

    public function testShouldBeAbleToCreateANewTeam()
    {
        $teamEntity = new TeamEntity(
            name: 'Internacional',
        );

        $response = $this->teamEloquentRepository->create($teamEntity);

        $this->assertInstanceOf(TeamRepositoryInterface::class, $this->teamEloquentRepository);
        $this->assertInstanceOf(TeamEntity::class, $response);
        $this->assertDatabaseHas('teams', ['name' => $teamEntity->name]);
    }

    public function testMustReturnNotFoundExceptionIfCannotFindTeamByPk()
    {
        try {
            $this->teamEloquentRepository->findByPk('fake_id');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testShouldBeAbleToFindTeamByPk()
    {
        $team = TeamModel::factory()->create();

        $response = $this->teamEloquentRepository->findByPk($team->id);

        $this->assertInstanceOf(TeamEntity::class, $response);
        $this->assertEquals($team->id, $response->id);
    }

    public function testMustReturnNotFoundExceptionIfCannotFindTeamByPkForUpdate()
    {
        try {
            $team = new TeamEntity(id: '', name: 'Internacional');

            $this->teamEloquentRepository->update($team);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testShouldBeAbleToUpdateATeam()
    {
        $databaseTeam = TeamModel::factory()->create();
        $team = new TeamEntity(id: $databaseTeam->id, name: 'Updated name');

        $response = $this->teamEloquentRepository->update($team);

        $this->assertInstanceOf(TeamEntity::class, $response);
        $this->assertEquals('Updated name', $response->name);
        $this->assertNotEquals($databaseTeam->name, $response->name);
    }

    public function testMustReturnNotFoundExceptionIfCannotFindTeamByPkForDelete()
    {
        try {
            $this->teamEloquentRepository->delete('fake_id');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testShouldBeAbleToDeleteATeam()
    {
        $databaseTeam = TeamModel::factory()->create();

        $response = $this->teamEloquentRepository->delete($databaseTeam->id);

        $this->assertTrue($response);
    }
}

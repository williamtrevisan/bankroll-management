<?php

namespace Tests\Unit\Core\UseCases\Team;

use Carbon\Carbon;
use Core\Domain\Entities\Team;
use Core\Domain\Repositories\TeamRepositoryInterface;
use Core\UseCases\Team\CreateTeamUseCase;
use Core\UseCases\Team\dtos\CreateTeamInputDTO;
use Core\UseCases\Team\dtos\CreateTeamOutputDTO;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateTeamUseCaseUnitTest extends TestCase
{
    public function testShouldBeAbleToCreateANewTeam()
    {
        $uuid = Uuid::uuid4()->toString();
        $createdAt = '2022-03-27 00:00:00';
        $teamEntity = Mockery::mock(Team::class, ['Internacional']);
        $teamEntity->shouldReceive('id')->andReturn($uuid);
        $teamEntity->shouldReceive('createdAt')->andReturn($createdAt);
        $teamRepository = Mockery::mock(stdClass::class, TeamRepositoryInterface::class);
        $teamRepository->shouldReceive('create')->andReturn($teamEntity);
        $createTeamInputDTO = Mockery::mock(CreateTeamInputDTO::class, ['Internacional']);

        $createTeamUseCase = new CreateTeamUseCase($teamRepository);
        $response = $createTeamUseCase->execute($createTeamInputDTO);

        $this->assertInstanceOf(CreateTeamOutputDTO::class, $response);
        $this->assertEquals('Internacional', $response->description);
        $this->assertEquals($uuid, $response->id);
        $this->assertTrue($response->is_active);
    }

    public function testShouldBeAbleToSpyIfCreateMethodHasBeenCalled()
    {
        $uuid = Uuid::uuid4()->toString();
        $createdAt = '2022-03-27 00:00:00';
        $teamEntity = Mockery::mock(Team::class, ['Internacional']);
        $teamEntity->shouldReceive('id')->andReturn($uuid);
        $teamEntity->shouldReceive('createdAt')->andReturn($createdAt);
        $teamRepositorySpy = Mockery::spy(stdClass::class, TeamRepositoryInterface::class);
        $teamRepositorySpy->shouldReceive('create')->andReturn($teamEntity);
        $createTeamInputDTO = Mockery::mock(CreateTeamInputDTO::class, ['Internacional']);

        $createTeamUseCase = new CreateTeamUseCase($teamRepositorySpy);
        $createTeamUseCase->execute($createTeamInputDTO);

        $teamRepositorySpy->shouldHaveReceived('create');
        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}

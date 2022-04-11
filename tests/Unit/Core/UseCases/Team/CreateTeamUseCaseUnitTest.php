<?php

namespace Tests\Unit\Core\UseCases\Team;

use Core\Domain\Entities\Team;
use Core\Domain\Repositories\TeamRepositoryInterface;
use Core\UseCases\Team\CreateTeamUseCase;
use Core\UseCases\Team\dtos\Create\CreateTeamInputDTO;
use Core\UseCases\Team\dtos\TeamOutputDTO;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateTeamUseCaseUnitTest extends TestCase
{
    public function testShouldBeAbleToCreateANewTeam()
    {
        $uuid = Uuid::uuid4()->toString();
        $teamEntity = Mockery::mock(Team::class, [$uuid, 'Internacional']);
        $teamEntity->shouldReceive('id')->andReturn($uuid);
        $teamEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $teamRepository = Mockery::mock(stdClass::class, TeamRepositoryInterface::class);
        $teamRepository->shouldReceive('create')->andReturn($teamEntity);
        $createTeamInputDTO = Mockery::mock(CreateTeamInputDTO::class, ['Internacional']);

        $createTeamUseCase = new CreateTeamUseCase($teamRepository);
        $response = $createTeamUseCase->execute($createTeamInputDTO);

        $this->assertInstanceOf(TeamOutputDTO::class, $response);
        $this->assertEquals('Internacional', $response->name);
        $this->assertEquals($uuid, $response->id);
        $this->assertTrue($response->is_active);
    }

    public function testShouldBeAbleToSpyIfCreateMethodHasBeenCalled()
    {
        $uuid = Uuid::uuid4()->toString();
        $teamEntity = Mockery::mock(Team::class, [$uuid, 'Internacional']);
        $teamEntity->shouldReceive('id')->andReturn($uuid);
        $teamEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
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

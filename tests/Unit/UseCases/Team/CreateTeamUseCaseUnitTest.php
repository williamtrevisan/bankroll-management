<?php

namespace Tests\Unit\UseCases\Team;

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
        $teamEntity = Mockery::mock(Team::class, ['Internacional']);
        $teamEntity->shouldReceive('id')->andReturn($uuid);
        $teamRepository = Mockery::mock(stdClass::class, TeamRepositoryInterface::class);
        $teamRepository->shouldReceive('save')->andReturn($teamEntity);
        $createTeamInputDTO = Mockery::mock(CreateTeamInputDTO::class, ['Internacional']);

        $createTeamUseCase = new CreateTeamUseCase($teamRepository);
        $response = $createTeamUseCase->execute($createTeamInputDTO);

        $this->assertInstanceOf(CreateTeamOutputDTO::class, $response);
        $this->assertEquals('Internacional', $response->description);
        $this->assertEquals($uuid, $response->id);
        $this->assertTrue($response->is_active);
    }

    public function testShouldBeAbleToSpyIfSaveMethodHasBeenCalled()
    {
        $uuid = Uuid::uuid4()->toString();
        $teamEntity = Mockery::mock(Team::class, ['Internacional']);
        $teamEntity->shouldReceive('id')->andReturn($uuid);
        $teamRepositorySpy = Mockery::spy(stdClass::class, TeamRepositoryInterface::class);
        $teamRepositorySpy->shouldReceive('save')->andReturn($teamEntity);
        $createTeamInputDTO = Mockery::mock(CreateTeamInputDTO::class, ['Internacional']);

        $createTeamUseCase = new CreateTeamUseCase($teamRepositorySpy);
        $createTeamUseCase->execute($createTeamInputDTO);

        $teamRepositorySpy->shouldHaveReceived('save');
        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}

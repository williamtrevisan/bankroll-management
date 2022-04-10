<?php

namespace Tests\Unit\Core\UseCases\Team;

use Core\Domain\Entities\Team;
use Core\Domain\Repositories\TeamRepositoryInterface;
use Core\UseCases\Team\dtos\Update\UpdateTeamInputDTO;
use Core\UseCases\Team\dtos\TeamOutputDTO;
use Core\UseCases\Team\UpdateTeamUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class UpdateTeamUseCaseUnitTest extends TestCase
{
    public function testShouldBeAbleToUpdateATeam()
    {
        $uuid = Uuid::uuid4()->toString();
        $teamEntity = Mockery::mock(Team::class, [
            $uuid,
            'Internacional'
        ]);
        $teamEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $teamEntity->shouldReceive('update');
        $teamRepository = Mockery::mock(stdClass::class, TeamRepositoryInterface::class);
        $teamRepository->shouldReceive('findByPk')->andReturn($teamEntity);
        $teamRepository->shouldReceive('update')->andReturn($teamEntity);
        $updateTeamInputDTO = Mockery::mock(UpdateTeamInputDTO::class, [$uuid, 'Grêmio']);

        $updateTeamUseCase = new UpdateTeamUseCase($teamRepository);
        $response = $updateTeamUseCase->execute($updateTeamInputDTO);

        $this->assertInstanceOf(TeamOutputDTO::class, $response);
    }

    public function testShouldBeAbleToSpyIfFindByPkAndUpdateMethodsHasBeenCalled()
    {
        $uuid = Uuid::uuid4()->toString();
        $teamEntity = Mockery::mock(Team::class, [
            $uuid,
            'Internacional'
        ]);
        $teamEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $teamEntity->shouldReceive('update');
        $teamRepositorySpy = Mockery::spy(stdClass::class, TeamRepositoryInterface::class);
        $teamRepositorySpy->shouldReceive('findByPk')->andReturn($teamEntity);
        $teamRepositorySpy->shouldReceive('update')->andReturn($teamEntity);
        $updateTeamInputDTO = Mockery::mock(UpdateTeamInputDTO::class, [$uuid, 'Grêmio']);

        $updateTeamUseCase = new UpdateTeamUseCase($teamRepositorySpy);
        $updateTeamUseCase->execute($updateTeamInputDTO);

        $teamRepositorySpy->shouldHaveReceived('findByPk');
        $teamRepositorySpy->shouldHaveReceived('update');
        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}

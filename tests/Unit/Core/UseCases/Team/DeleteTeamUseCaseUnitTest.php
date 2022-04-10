<?php

namespace Tests\Unit\Core\UseCases\Team;

use Core\Domain\Entities\Team;
use Core\Domain\Repositories\TeamRepositoryInterface;
use Core\UseCases\Team\dtos\TeamInputDTO;
use Core\UseCases\Team\dtos\Delete\DeleteTeamOutputDTO;
use Core\UseCases\Team\DeleteTeamUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class DeleteTeamUseCaseUnitTest extends TestCase
{
    public function testShouldBeAbleToDeleteATeam()
    {
        $uuid = Uuid::uuid4()->toString();
        $teamRepository = Mockery::mock(stdClass::class, TeamRepositoryInterface::class);
        $teamRepository->shouldReceive('delete')->andReturn(true);
        $teamInputDTO = Mockery::mock(TeamInputDTO::class, [$uuid]);

        $deleteTeamUseCase = new DeleteTeamUseCase($teamRepository);
        $response = $deleteTeamUseCase->execute($teamInputDTO);

        $this->assertInstanceOf(DeleteTeamOutputDTO::class, $response);
        $this->assertTrue($response->success);
    }

    public function testShouldReturnFalseIfNotBeAbleToDeleteATeam()
    {
        $uuid = Uuid::uuid4()->toString();
        $teamRepository = Mockery::mock(stdClass::class, TeamRepositoryInterface::class);
        $teamRepository->shouldReceive('delete')->andReturn(false);
        $teamInputDTO = Mockery::mock(TeamInputDTO::class, [$uuid]);

        $deleteTeamUseCase = new DeleteTeamUseCase($teamRepository);
        $response = $deleteTeamUseCase->execute($teamInputDTO);

        $this->assertInstanceOf(DeleteTeamOutputDTO::class, $response);
        $this->assertFalse($response->success);
    }

    public function testShouldBeAbleToSpyIfDeleteMethodHasBeenCalled()
    {
        $uuid = Uuid::uuid4()->toString();
        $teamRepositorySpy = Mockery::spy(stdClass::class, TeamRepositoryInterface::class);
        $teamRepositorySpy->shouldReceive('delete')->andReturn(true);
        $teamInputDTO = Mockery::mock(TeamInputDTO::class, [$uuid]);

        $deleteTeamUseCase = new DeleteTeamUseCase($teamRepositorySpy);
        $deleteTeamUseCase->execute($teamInputDTO);

        $teamRepositorySpy->shouldHaveReceived('delete');
        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}

<?php

namespace Tests\Unit\Core\UseCases\Team;

use Core\Domain\Entities\Team;
use Core\Domain\Repositories\TeamRepositoryInterface;
use Core\UseCases\Team\dtos\TeamInputDTO;
use Core\UseCases\Team\dtos\TeamOutputDTO;
use Core\UseCases\Team\ListTeamUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class ListTeamUseCaseUnitTest extends TestCase
{
    public function testShouldBeAbleToListATeam()
    {
        $uuid = Uuid::uuid4()->toString();
        $teamEntity = Mockery::mock(Team::class, [
            $uuid,
            'Internacional'
        ]);
        $teamEntity->shouldReceive('id')->andReturn($uuid);
        $teamEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $teamRepository = Mockery::mock(stdClass::class, TeamRepositoryInterface::class);
        $teamRepository->shouldReceive('findByPk')
            ->with($uuid)
            ->andReturn($teamEntity);
        $teamInputDTO = Mockery::mock(TeamInputDTO::class, [$uuid]);

        $listTeamUseCase = new ListTeamUseCase($teamRepository);
        $response = $listTeamUseCase->execute($teamInputDTO);

        $this->assertInstanceOf(TeamOutputDTO::class, $response);
        $this->assertEquals('Internacional', $response->description);
        $this->assertEquals($uuid, $response->id);
    }

    public function testShouldBeAbleToSpyIfFindByPkMethodsHasBeenCalled()
    {
        $uuid = Uuid::uuid4()->toString();
        $teamEntity = Mockery::mock(Team::class, [
            $uuid,
            'Internacional'
        ]);
        $teamEntity->shouldReceive('id')->andReturn($uuid);
        $teamEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $teamRepositorySpy = Mockery::spy(stdClass::class, TeamRepositoryInterface::class);
        $teamRepositorySpy->shouldReceive('findByPk')
            ->with($uuid)
            ->andReturn($teamEntity);
        $teamInputDTO = Mockery::mock(TeamInputDTO::class, [$uuid]);

        $listTeamUseCase = new ListTeamUseCase($teamRepositorySpy);
        $listTeamUseCase->execute($teamInputDTO);

        $teamRepositorySpy->shouldHaveReceived('findByPk');
        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}

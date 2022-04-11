<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\TeamController;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use App\Models\Team as TeamModel;
use App\Repositories\Eloquent\TeamEloquentRepository;
use Core\Domain\Repositories\TeamRepositoryInterface;
use Core\UseCases\Team\CreateTeamUseCase;
use Core\UseCases\Team\DeleteTeamUseCase;
use Core\UseCases\Team\ListTeamUseCase;
use Core\UseCases\Team\UpdateTeamUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;

class TeamControllerTest extends TestCase
{
    protected TeamRepositoryInterface $teamEloquentRepository;
    protected Controller $teamController;

    protected function setUp(): void
    {
        $this->teamEloquentRepository = new TeamEloquentRepository(new TeamModel());
        $this->teamController = new TeamController();

        parent::setUp();
    }

    public function testShouldBeAbleToCreateANewTeam()
    {
        $createTeamUseCase = new CreateTeamUseCase($this->teamEloquentRepository);
        $request = new StoreTeamRequest();
        $request->headers->set('Content-type', 'application/json');
        $request->setJson(new ParameterBag(['name' => 'Internacional']));

        $response = $this->teamController->store($request, $createTeamUseCase);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_CREATED, $response->status());
    }

    public function testShouldBeAbleToShowATeam()
    {
        $team = Team::factory()->create();

        $response = $this->teamController->show(
            listTeamUseCase: new ListTeamUseCase($this->teamEloquentRepository),
            id: $team->id
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
    }

    public function testShouldBeAbleToUpdateATeam()
    {
        $team = Team::factory()->create();
        $request = new UpdateTeamRequest();
        $request->headers->set('Content-type', 'application/json');
        $request->setJson(new ParameterBag(['name' => 'Updated']));

        $response = $this->teamController->update(
            request: $request,
            updateTeamUseCase: new UpdateTeamUseCase($this->teamEloquentRepository),
            id: $team->id
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertDatabaseHas('teams', ['name' => 'Updated']);
    }

    public function testShouldBeAbleToDeleteATeam()
    {
        $team = Team::factory()->create();

        $response = $this->teamController->destroy(
            deleteTeamUseCase: new DeleteTeamUseCase($this->teamEloquentRepository),
            id: $team->id
        );

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->status());
        $this->assertSoftDeleted('teams', ['id' => $team->id]);
    }
}

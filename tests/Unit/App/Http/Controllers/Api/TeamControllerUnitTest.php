<?php

namespace Tests\Unit\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\TeamController;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Team as TeamModel;
use App\Repositories\Eloquent\TeamEloquentRepository;
use Core\Domain\Repositories\TeamRepositoryInterface;
use Core\UseCases\Team\CreateTeamUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;

class TeamControllerUnitTest extends TestCase
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
        $request = new StoreCategoryRequest();
        $request->headers->set('Content-type', 'application/json');
        $request->setJson(new ParameterBag(['description' => 'Internacional']));

        $response = $this->teamController->store($request, $createTeamUseCase);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_CREATED, $response->status());
    }
}

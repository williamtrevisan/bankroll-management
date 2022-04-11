<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Resources\TeamResource;
use Core\UseCases\Team\CreateTeamUseCase;
use Core\UseCases\Team\DeleteTeamUseCase;
use Core\UseCases\Team\dtos\Create\CreateTeamInputDTO;
use Core\UseCases\Team\dtos\TeamInputDTO;
use Core\UseCases\Team\dtos\Update\UpdateTeamInputDTO;
use Core\UseCases\Team\ListTeamUseCase;
use Core\UseCases\Team\UpdateTeamUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TeamController extends Controller
{
    public function store(StoreTeamRequest $request, CreateTeamUseCase $createTeamUseCase): JsonResponse
    {
        $createTeamInputDTO = new CreateTeamInputDTO(
            description: $request->description,
            isActive: (bool) $request->is_active ?? true
        );

        $response = $createTeamUseCase->execute($createTeamInputDTO);

        return (new TeamResource($response))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ListTeamUseCase $listTeamUseCase, string $id): JsonResponse
    {
        $teamInputDTO = new TeamInputDTO(id: $id);

        $team = $listTeamUseCase->execute($teamInputDTO);

        return (new TeamResource($team))->response();
    }

    public function update(
        UpdateTeamRequest $request,
        UpdateTeamUseCase $updateTeamUseCase,
        string $id
    ): JsonResponse {
        $updateTeamInputDTO = new UpdateTeamInputDTO(id: $id, description: $request->description);

        $response = $updateTeamUseCase->execute($updateTeamInputDTO);

        return (new TeamResource($response))->response();
    }

    public function destroy(DeleteTeamUseCase $deleteTeamUseCase, string $id): Response
    {
        $teamInputDTO = new TeamInputDTO(id: $id);

        $deleteTeamUseCase->execute($teamInputDTO);

        return response()->noContent();
    }
}

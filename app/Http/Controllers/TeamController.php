<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\TeamResource;
use Core\UseCases\Team\CreateTeamUseCase;
use Core\UseCases\Team\dtos\CreateTeamInputDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TeamController extends Controller
{
    public function store(StoreCategoryRequest $request, CreateTeamUseCase $createTeamUseCase): JsonResponse
    {
        $response = $createTeamUseCase->execute(
            input: new CreateTeamInputDTO(
                description: $request->description,
                isActive: (bool) $request->is_active ?? true,
            )
        );

        return (new TeamResource(collect($response)))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\TeamResource;
use Core\UseCases\Team\CreateTeamUseCase;
use Core\UseCases\Team\dtos\CreateTeamInputDTO;
use Illuminate\Http\Response;

class TeamController extends Controller
{
    public function store(StoreCategoryRequest $request, CreateTeamUseCase $createTeamUseCase)
    {
        $response = $createTeamUseCase->execute(
            input: new CreateTeamInputDTO(
                description: $request->description,
                isActive: (bool) $request->is_active ?? true,
            )
        );

        return (new TeamResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}

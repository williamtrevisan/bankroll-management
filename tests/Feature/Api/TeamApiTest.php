<?php

namespace Tests\Feature\Api;

use App\Models\Team;
use Illuminate\Http\Response;
use Tests\TestCase;

class TeamApiTest extends TestCase
{
    protected $endpoint = '/api/teams';

    public function testMustBeReturnValidationsErrorWhenReceivedInvalidDataForStoreMethod()
    {
        $data = [];

        $response = $this->postJson($this->endpoint, $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name'
            ]
        ]);
    }

    public function testShouldBeAbleToCreateANewTeam()
    {
        $data = [
            'name' => 'Internacional'
        ];

        $response = $this->postJson($this->endpoint, $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertEquals('Internacional', $response['data']['name']);
        $this->assertFalse($response['data']['is_active']);
        $this->assertDatabaseHas('teams', [
            'id' => $response['data']['id'],
            'is_active' => false
        ]);
    }

    public function testMustBeReturnHttpNotFoundIfReceiveInvalidIdForShowMethod()
    {
        $response = $this->getJson("$this->endpoint/fake_id");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testShouldBeAbleToShowATeam()
    {
        $team = Team::factory()->create();

        $response = $this->getJson("$this->endpoint/$team->id");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'is_active',
                'created_at',
            ]
        ]);
        $this->assertEquals($team->id, $response['data']['id']);
    }

    public function testMustBeReturnValidationsErrorWhenReceivedInvalidDataForUpdateMethod()
    {
        $team = Team::factory()->create();

        $response = $this->putJson("$this->endpoint/$team->id", []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name'
            ]
        ]);
    }

    public function testMustBeReturnHttpNotFoundIfReceiveInvalidIdForUpdateMethod()
    {
        $data = [
            'name' => 'Internacional',
        ];

        $response = $this->putJson("$this->endpoint/fake_id", $data);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testShouldBeAbleToUpdateATeam()
    {
        $team = Team::factory()->create();
        $data = [
            'name' => 'Internacional',
        ];

        $response = $this->putJson("$this->endpoint/$team->id", $data);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'is_active',
                'created_at',
            ]
        ]);
        $this->assertDatabaseHas('teams', [
            'name' => 'Internacional'
        ]);
    }

    public function testMustBeReturnHttpNotFoundIfReceiveInvalidIdForDestroyMethod()
    {
        $response = $this->deleteJson("$this->endpoint/fake_id");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testShouldBeAbleToDeleteATeam()
    {
        $team = Team::factory()->create();

        $response = $this->deleteJson("$this->endpoint/$team->id");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertSoftDeleted('teams', [
           'id' => $team->id,
        ]);
    }
}

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
                'description'
            ]
        ]);
    }

    public function testShouldBeAbleToCreateANewTeam()
    {
        $data = [
            'description' => 'Internacional'
        ];

        $response = $this->postJson($this->endpoint, $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertEquals('Internacional', $response['data']['description']);
        $this->assertFalse($response['data']['is_active']);
        $this->assertDatabaseHas('teams', [
            'id' => $response['data']['id'],
            'is_active' => false
        ]);
    }

    public function testMustBeReturnValidationsErrorWhenReceivedInvalidDataForUpdateMethod()
    {
        $team = Team::factory()->create();

        $response = $this->putJson("$this->endpoint/$team->id", []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'description'
            ]
        ]);
    }

    public function testMustBeReturnHttpNotFoundIfReceiveInvalidIdForUpdateMethod()
    {
        $data = [
            'description' => 'Internacional',
        ];

        $response = $this->putJson("$this->endpoint/fake_id", $data);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testShouldBeAbleToUpdateATeam()
    {
        $team = Team::factory()->create();
        $data = [
            'description' => 'Internacional',
        ];

        $response = $this->putJson("$this->endpoint/$team->id", $data);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'description',
                'is_active',
                'created_at',
            ]
        ]);
        $this->assertDatabaseHas('teams', [
            'description' => 'Internacional'
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

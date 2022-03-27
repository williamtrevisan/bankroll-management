<?php

namespace Tests\Feature\Api;

use Illuminate\Http\Response;
use Tests\TestCase;

class TeamApiTest extends TestCase
{
    protected $endpoint = '/api/teams';

    public function testMustBeReturnValidationsErrorWhenReceivedInvalidData()
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
    }
}

<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamEloquentRepositoryIntegrationTest extends TestCase
{
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

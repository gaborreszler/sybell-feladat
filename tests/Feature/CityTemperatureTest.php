<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CityTemperatureTest extends TestCase
{
    public function test_can_see_metrics_api(): void
    {
        $response = $this->get('/api/v1/city-temperatures/city/1/metrics');

        $response
            ->assertStatus(200)
            ->assertHeader('content-type', 'text/plain');
    }
}

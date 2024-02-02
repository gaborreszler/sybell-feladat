<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CityTest extends TestCase
{
    public function test_can_store_city_web(): void
    {
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user, 'web')
            ->post('/cities', [
                'name' => 'Moscow',
                'frequency_schedule' => 1,
                'frequency_schedule_custom' => '* * * * *',
            ]);

        $response->assertRedirectToRoute('city-temperatures.chart');
    }

    public function test_can_see_cities_api(): void
    {
        $response = $this->get('/api/v1/cities');

        $response->assertStatus(200);
    }
}

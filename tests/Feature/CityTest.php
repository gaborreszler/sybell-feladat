<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class CityTest extends TestCase
{
    public function testCanStoreCityWeb(): void
    {
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user, 'web')
            ->post('/cities', [
                'name' => 'Moscow',
                'frequency_schedule' => 1,
                'frequency_schedule_custom' => '* * * * *',
            ])
        ;

        $response->assertRedirectToRoute('city-temperatures.chart');
    }

    public function testCanSeeCitiesApi(): void
    {
        $response = $this->get('/api/v1/cities');

        $response->assertStatus(200);
    }
}

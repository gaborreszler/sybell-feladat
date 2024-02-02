<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class CityTemperatureTest extends TestCase
{
    public function testCanSeeMetricsApi(): void
    {
        $response = $this->get('/api/v1/city-temperatures/city/1/metrics');

        $response
            ->assertStatus(200)
            ->assertHeader('content-type', 'text/plain')
        ;
    }
}

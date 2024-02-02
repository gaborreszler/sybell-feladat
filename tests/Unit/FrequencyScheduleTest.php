<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\FrequencySchedule;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class FrequencyScheduleTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testFrequencyScheduleHasCorrectTypeOfProperties(): void
    {
        $frequencySchedule = FrequencySchedule::factory()->create();

        self::assertIsInt($frequencySchedule->id);
        self::assertIsString($frequencySchedule->frequency);
        self::assertIsString($frequencySchedule->schedule);
    }
}

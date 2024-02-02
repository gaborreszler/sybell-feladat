<?php

namespace Tests\Unit;

use App\Models\FrequencySchedule;
use Tests\TestCase;

class FrequencyScheduleTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_frequency_schedule_has_correct_type_of_properties(): void
    {
        $frequencySchedule = FrequencySchedule::factory()->create();

        $this->assertIsInt($frequencySchedule->id);
        $this->assertIsString($frequencySchedule->frequency);
        $this->assertIsString($frequencySchedule->schedule);
    }
}

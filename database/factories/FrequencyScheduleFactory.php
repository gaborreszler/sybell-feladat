<?php

namespace Database\Factories;

use Database\Seeders\FrequencyScheduleSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FrequencySchedule>
 */
class FrequencyScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'frequency' => $this->faker->sentence(3),
            'schedule' => $this->faker->randomElement(FrequencyScheduleSeeder::FREQUENCY_SCHEDULES),
        ];
    }
}

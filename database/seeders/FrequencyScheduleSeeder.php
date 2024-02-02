<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\FrequencySchedule;
use Illuminate\Database\Seeder;

class FrequencyScheduleSeeder extends Seeder
{
    public const array FREQUENCY_SCHEDULES = [
        'every minute' => '* * * * *',
        'every two minutes' => '*/2 * * * *',
        'every three minutes' => '*/3 * * * *',
        'every four minutes' => '*/4 * * * *',
        'every five minutes' => '*/5 * * * *',
        'every ten minutes' => '*/10 * * * *',
        'every fifteen minutes' => '*/15 * * * *',
        'every thirty minutes' => '*/30 * * * *',
        'every hour' => '0 * * * *',
        'every two hours' => '0 */2 * * *',
        'every three hours' => '0 */3 * * *',
        'every four hours' => '0 */4 * * *',
        'every six hours' => '0 */5 * * *',
        'on weekdays' => '0 0 * * 1-5',
        'on weekends' => '0 0 * * 6,0',
        'on mondays' => '0 0 * * 1',
        'on tuesdays' => '0 0 * * 2',
        'on wednesdays' => '0 0 * * 3',
        'on thursdays' => '0 0 * * 4',
        'on fridays' => '0 0 * * 5',
        'on saturdays' => '0 0 * * 6',
        'on sundays' => '0 0 * * 0',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::FREQUENCY_SCHEDULES as $frequency => $schedule) {
            $frequencySchedule = new FrequencySchedule();
            $frequencySchedule->frequency = $frequency;
            $frequencySchedule->schedule = $schedule;
            $frequencySchedule->save();
        }
    }
}

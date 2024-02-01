<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\FetchWeather;
use App\Models\City;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $citys = City::query()
            ->selectRaw('(ST_AsGeoJSON(coordinates)) AS "coordinates"')
            ->addSelect([
                'id',
                'frequency_schedule_id',
                'name',
            ])
            ->with('frequencySchedule')
            ->get();

        foreach ($citys as $city) {
            $city->coordinates = json_decode($city->coordinates, true)['coordinates'];
            $schedule->command(FetchWeather::class, [$city])->cron($city->frequencySchedule->schedule);
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

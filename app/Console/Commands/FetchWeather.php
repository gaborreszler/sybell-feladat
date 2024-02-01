<?php

namespace App\Console\Commands;

use App\Models\CityTemperature;
use App\Services\OpenMeteo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-weather {city}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches weather data from OpenMeteo.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $city = json_decode($this->argument('city'));

        Log::info(sprintf(
            'Running the weather schedule task for %s with cron schedule \'%s\' (%s).',
            $city->name,
            $city->frequency_schedule->schedule,
            $city->frequency_schedule->frequency
        ));

        $openmeteo = new OpenMeteo($city->name);

        $cityTemperature = new CityTemperature();
        $cityTemperature->city_id = $city->id;
        $cityTemperature->temperature = $openmeteo->getCurrentTemperature();
        $cityTemperature->relative_humidity = $openmeteo->getCurrentRelativeHumidity();
        $cityTemperature->wind_speed = $openmeteo->getCurrentWindSpeed();
        $cityTemperature->current = json_encode($openmeteo->getCurrent());
        $cityTemperature->current_units = json_encode($openmeteo->getCurrentUnits());
        $cityTemperature->hourly = json_encode($openmeteo->getHourly());
        $cityTemperature->hourly_units = json_encode($openmeteo->getHourlyUnits());
        $cityTemperature->save();
    }
}

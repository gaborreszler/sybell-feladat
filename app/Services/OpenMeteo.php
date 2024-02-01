<?php

namespace App\Services;

use App\Exceptions\OpenMeteoCityNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use stdClass;

class OpenMeteo
{
    protected stdClass $geocode;
    protected stdClass $forecast;

    /**
     * @param array<string, float> $coordinates
     */
    public function __construct(string $city = 'Budapest', array $coordinates = [])
    {
        if(empty($coordinates)) {
            try {
                $this->geocode = $this->getGeocode($city);
            } catch (OpenMeteoCityNotFoundException $exception) {
                Log::error($exception);

                abort($exception->code, $exception);
            }
        } else {
            $this->geocode = new stdClass();
            $this->geocode->latitude = $coordinates['latitude'];
            $this->geocode->longitude = $coordinates['longitude'];
        }

        $this->forecast = $this->getForecast($this->geocode->latitude, $this->geocode->longitude);
    }


    /**
     * @param string $city
     * @return stdClass
     * @throws OpenMeteoCityNotFoundException
     */
    private function getGeocode(string $city): stdClass
    {
        $response = Http::withUrlParameters([
            'endpoint' => 'https://geocoding-api.open-meteo.com/',
            'version' => 'v1',
            'page' => 'search',
        ])->get('{+endpoint}/{version}/{page}', [
            'name' => $city,
            'longitude' => 1,
        ]);

        $data = JsonResponse::fromJsonString($response->body())->getData();

        if (!isset($data->results)) {
            throw new OpenMeteoCityNotFoundException(
                sprintf('No query results for the given city. (%s)', $city)
            );
        }

        return $data->results[0];
    }

    public function getCoordinates(): array
    {
        return [
            'latitude' => $this->geocode->latitude,
            'longitude' => $this->geocode->longitude,
        ];
    }

    private function getForecast(float $latitude, float $longitude): stdClass
    {
        $response = Http::withUrlParameters([
            'endpoint' => 'https://api.open-meteo.com/',
            'version' => 'v1',
            'page' => 'forecast',
        ])->get('{+endpoint}/{version}/{page}', [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'current' => ['temperature_2m', 'relative_humidity_2m', 'wind_speed_10m'],
            'hourly' => [
                'temperature_2m',
                'relative_humidity_2m',
                'wind_speed_10m'
            ],
        ]);

        return JsonResponse::fromJsonString($response->body())->getData();
    }

    public function getCurrent()
    {
        return $this->forecast->current;
    }

    public function getCurrentUnits()
    {
        return $this->forecast->current_units;
    }

    public function getHourly()
    {
        return $this->forecast->hourly;
    }

    public function getHourlyUnits()
    {
        return $this->forecast->hourly_units;
    }

    public function getCurrentTemperature(): float
    {
        return $this->getCurrent()->temperature_2m;
    }

    public function getCurrentTemperatureUnit(): string
    {
        return $this->getCurrentUnits()->temperature_2m;
    }

    public function getHumanReadableCurrentTemperature(): string
    {
        return sprintf(
            '%g%s',
            $this->getCurrentTemperature(),
            $this->getCurrentTemperatureUnit()
        );
    }

    public function getCurrentRelativeHumidity(): float
    {
        return $this->getCurrent()->relative_humidity_2m;
    }

    public function getCurrentRelativeHumidityUnit(): string
    {
        return $this->getCurrentUnits()->relative_humidity_2m;
    }

    public function getHumanReadableCurrentRelativeHumidity(): string
    {
        return sprintf(
            '%g%s',
            $this->getCurrentRelativeHumidity(),
            $this->getCurrentRelativeHumidityUnit()
        );
    }

    public function getCurrentWindSpeed(): float
    {
        return $this->getCurrent()->wind_speed_10m;
    }

    public function getCurrentWindSpeedUnit(): string
    {
        return $this->getCurrentUnits()->wind_speed_10m;
    }

    public function getHumanReadableCurrentWindSpeed(): string
    {
        return sprintf(
            '%g %s',
            $this->getCurrentWindSpeed(),
            $this->getCurrentWindSpeedUnit()
        );
    }
}

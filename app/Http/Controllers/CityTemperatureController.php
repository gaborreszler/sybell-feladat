<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCityTemperatureRequest;
use App\Http\Requests\UpdateCityTemperatureRequest;
use App\Models\City;
use App\Models\CityTemperature;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityTemperatureController extends Controller
{
    protected Request $request;

    public function __construct()
    {
        $this->request = request();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cityTemperatures = CityTemperature::all();

        if ($this->request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data' => $cityTemperatures
            ]);
        }

        return view('frequency-schedule.index', compact('cityTemperatures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCityTemperatureRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CityTemperature $cityTemperature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CityTemperature $cityTemperature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityTemperatureRequest $request, CityTemperature $cityTemperature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CityTemperature $cityTemperature)
    {
        //
    }

    public function metrics(City $city): Response
    {
        $cityTemperature = $city
            ->cityTemperatures()
            ->orderByDesc('created_at')
            ->first();

        $hourly = json_decode($cityTemperature->hourly);
        $metrics = [];
        foreach ($hourly->time as $key => $time) {
            $metrics[] = sprintf(
                'http_temperatures_%s{city=%s, datetime=%s} %f',
                json_decode($cityTemperature->hourly_units)->temperature_2m === '°C'
                    ? 'celsius'
                    : 'fahrenheit',
                $cityTemperature->city->name,
                $time,
                $hourly->temperature_2m[$key],
            );

            $metrics[] = sprintf(
                'http_relative_humidity_ratio{city=%s, datetime=%s} %f',
                $cityTemperature->city->name,
                $time,
                $hourly->relative_humidity_2m[$key] / 100,
            );

            $metrics[] = sprintf(
                'http_wind_speed_%s{city=%s, datetime=%s} %f',
                json_decode($cityTemperature->hourly_units)->wind_speed_10m === 'kilometers_per_hour'
                    ? 'kilometers_per_hour'
                    : 'miles_per_hour',
                $cityTemperature->city->name,
                $time,
                $hourly->wind_speed_10m[$key],
            );
        }

        $response = new Response();
        $response->headers->set('content-type', 'text/plain');

        return $response->setContent(implode(PHP_EOL, $metrics));
    }

    public function chart()
    {
        $cityTemperatures = CityTemperature::query()
            ->groupBy('city_id')
            ->orderByDesc('created_at')
            ->with('city')
            ->get();

        return view('city-temperatures.chart', compact('cityTemperatures'));
    }
}

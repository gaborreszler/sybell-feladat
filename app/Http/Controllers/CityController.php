<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use App\Models\FrequencySchedule;
use App\Services\CountriesNow;
use App\Services\OpenMeteo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
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
        $cities = City::all(['id', 'name']);

        if ($this->request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data' => $cities,
            ]);
        }

        return view('cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = CountriesNow::getCapitals();
        $frequencySchedules = FrequencySchedule::all();

        $options = [];
        foreach ($frequencySchedules as $frequencySchedule) {
            $options[$frequencySchedule->id] = sprintf(
                '%s (%s)',
                $frequencySchedule->schedule,
                $frequencySchedule->frequency,
            );
        }

        return view('cities.create', compact('cities', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCityRequest $request)
    {
        $validated = $request->validated();
        $cityName = $validated['name'];

        $openmeteo = new OpenMeteo($cityName);
        $coordinates = $openmeteo->getCoordinates();

        if (null !== $validated['frequency_schedule_custom']) {
            $frequencySchedule = FrequencySchedule::query()->firstOrNew(
                ['schedule' => $validated['frequency_schedule_custom']],
                ['frequency' => 'N/A']
            );
            $frequencySchedule->save();
        }

        $city = new City();
        $city->name = $cityName;
        $city->frequency_schedule_id = $validated['frequency_schedule'] ?? $frequencySchedule->id;
        $city->coordinates = DB::raw(
            sprintf(
                'POINT(%g, %g)',
                $coordinates['latitude'],
                $coordinates['longitude']
            )
        );
        $city->save();

        return redirect()->route('city-temperatures.chart');
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city): void {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city): void {}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        $city->name = $request->validated('name');
        $city->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data' => $city,
            ]);
        }

        return redirect()->route('cities.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $city->delete();

        if ($this->request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Success',
            ]);
        }

        return redirect()->route('cities.index');
    }
}

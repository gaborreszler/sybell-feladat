<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFrequencyScheduleRequest;
use App\Http\Requests\UpdateFrequencyScheduleRequest;
use App\Models\FrequencySchedule;
use Illuminate\Http\Request;

class FrequencyScheduleController extends Controller
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
        $frequencySchedules = FrequencySchedule::all(['id', 'frequency', 'schedule']);

        if ($this->request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data' => $frequencySchedules
            ]);
        }

        return view('frequency-schedule.index', compact('frequencySchedules'));
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
    public function store(StoreFrequencyScheduleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FrequencySchedule $frequencySchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FrequencySchedule $frequencySchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFrequencyScheduleRequest $request, FrequencySchedule $frequencySchedule)
    {
        $frequencySchedule->frequency = $request->validated('frequency');
        $frequencySchedule->schedule = $request->validated('schedule');
        $frequencySchedule->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data' => $frequencySchedule
            ]);
        }

        return redirect()->route('frequency-schedule.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FrequencySchedule $frequencySchedule)
    {
        $frequencySchedule->delete();

        if ($this->request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Success',
            ]);
        }

        return redirect()->route('frequency-schedule.index');
    }
}

<?php

declare(strict_types=1);

use App\Http\Controllers\CityController;
use App\Http\Controllers\CityTemperatureController;
use App\Http\Controllers\FrequencyScheduleController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', static fn (Request $request) => $request->user());

Route::prefix('v1')->group(function () {
    Route::resource('frequency-schedules', FrequencyScheduleController::class)->only([
        'index', 'update', 'destroy'
    ]);
    Route::resource('cities', CityController::class)->only([
        'index', 'update', 'destroy'
    ]);

    Route::controller(CityTemperatureController::class)->group(function () {
        Route::get('/city-temperatures', [CityTemperatureController::class, 'index'])->name('city-temperatures.index');
        Route::patch('/city-temperatures/{id}', [CityTemperatureController::class, 'update'])->name('city-temperatures.update');
        Route::delete('/city-temperatures/{id}', [CityTemperatureController::class, 'destroy'])->name('city-temperatures.destroy');
        Route::get('/city-temperatures/city/{city}/metrics', [CityTemperatureController::class, 'metrics'])->name('city-temperatures.metrics');
    });
});

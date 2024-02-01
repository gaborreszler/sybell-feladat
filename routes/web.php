<?php

declare(strict_types=1);

use App\Http\Controllers\CityController;
use App\Http\Controllers\CityTemperatureController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', static fn () => view('welcome'));

Route::get('/dashboard', static fn () => view('dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(static function (): void {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('cities', CityController::class);

    Route::controller(CityTemperatureController::class)->group(static function (): void {
        Route::get('/forecasts', [CityTemperatureController::class, 'chart'])->name('city-temperatures.chart');
    });
});

require __DIR__.'/auth.php';

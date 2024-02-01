<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $hidden = ['coordinates'];

    public function frequencySchedule(): BelongsTo
    {
        return $this->belongsTo(FrequencySchedule::class);
    }

    public function cityTemperatures(): HasMany
    {
        return $this->hasMany(CityTemperature::class);
    }
}

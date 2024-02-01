<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CityTemperature extends Model
{
    use HasFactory;

    protected $casts = [
        'current' => 'object',
        'hourly' => 'object',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}

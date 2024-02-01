<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrequencySchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'frequency',
        'schedule',
    ];
}

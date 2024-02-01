<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('city_temperatures', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('city_id')->constrained(
                table: 'cities',
                indexName: 'city_temperatures_city_id'
            )->cascadeOnDelete();
            $table->float('temperature');
            $table->unsignedTinyInteger('relative_humidity');
            $table->float('wind_speed');
            $table->json('current');
            $table->json('current_units');
            $table->json('hourly');
            $table->json('hourly_units');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city_temperatures');
    }
};

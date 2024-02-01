<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class CountriesNow
{
    public static function getCountries(): void {}

    public static function getCapitals()
    {
        $response = Http::get('https://countriesnow.space/api/v0.1/countries/capital');

        $data = JsonResponse::fromJsonString($response->body())->getData();
        $capitals = array_column($data->data, 'capital');

        sort($capitals);

        return array_unique(array_filter($capitals));
    }

    public static function getCapital(string $country = 'Hungary'): void {}
}

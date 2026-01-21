<?php

use Illuminate\Support\Facades\Route;
use App\Services\CityService;
use App\Services\OpenWeatherService;
use App\Services\ComfortIndexService;


Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'time' => now()->toDateTimeString(),
    ]);
});


Route::get('/cities/test', function (CityService $cityService) {
    return $cityService->getCityCodes();
});


Route::get('/cities/debug', function () {
    $path = storage_path('app/data/cities.json');

    return response()->json([
        'exists' => file_exists($path),
        'path' => $path,
        'size' => file_exists($path) ? filesize($path) : null,
        'first_200_chars' => file_exists($path) ? substr(file_get_contents($path), 0, 200) : null,
        'decoded_keys' => file_exists($path) ? array_keys(json_decode(file_get_contents($path), true) ?? []) : null,
    ]);
});


Route::get('/weather/test', function (OpenWeatherService $ow) {
    // Colombo from your cities.json
    return $ow->getWeatherByCityId('1248991');
});

Route::get('/openweather/key-check', function () {
    $key = env('OPENWEATHER_API_KEY');

    return response()->json([
        'has_key' => !empty($key),
        'key_length' => $key ? strlen($key) : 0,
    ]);
});


Route::get('/weather/cache-status/{cityId}', function (
    string $cityId,
    OpenWeatherService $ow
) {
    $fromCache = false;
    $ow->getWeatherByCityId($cityId, $fromCache);

    return response()->json([
        'city_id' => $cityId,
        'cache' => $fromCache ? 'HIT' : 'MISS',
        'checked_at' => now()->toDateTimeString(),
    ]);
});



Route::get('/comfort/test/{cityId}', function (
    string $cityId,
    OpenWeatherService $ow,
    ComfortIndexService $ci
) {
    $weather = $ow->getWeatherByCityId($cityId);
    $score = $ci->calculate($weather);

    return response()->json([
        'city_id' => $cityId,
        'comfort_index' => $score,
    ]);
});


Route::get('/dashboard', function (
    CityService $cities,
    OpenWeatherService $ow,
    ComfortIndexService $ci
) {
    $cityIds = $cities->getCityCodes();

    $rows = collect($cityIds)->map(function ($cityId) use ($ow, $ci) {
        $weather = $ow->getWeatherByCityId($cityId);

        return [
            'city_id' => (string) $cityId,
            'city_name' => $weather['name'] ?? null,
            'weather_description' => $weather['weather'][0]['description'] ?? null,
            'temp_c' => isset($weather['main']['temp']) ? round($weather['main']['temp'] - 273.15, 2) : null,
            'comfort_index' => $ci->calculate($weather),
            //'raw' => $weather, // keep for now; we can remove later
        ];
    });

    $sorted = $rows->sortByDesc('comfort_index')->values();

    // Add rank
    $ranked = $sorted->map(function ($row, $index) {
        $row['rank'] = $index + 1;
        return $row;
    });

    return response()->json([
        'count' => $ranked->count(),
        'generated_at' => now()->toDateTimeString(),
        'data' => $ranked,
    ]);
});

<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class OpenWeatherService
{
    public function getWeatherByCityId(string $cityId, bool &$fromCache = null): array
    {
        $cacheKey = "weather.raw.{$cityId}";

        if (Cache::has($cacheKey)) {
            $fromCache = true;
            return Cache::get($cacheKey);
        }

        $fromCache = false;

        $baseUrl = config('services.openweather.base_url');
        $apiKey  = config('services.openweather.key');

        $response = Http::get($baseUrl . '/weather', [
            'id' => $cityId,
            'appid' => $apiKey,
        ]);

        if ($response->failed()) {
            throw new \RuntimeException(
                "OpenWeather failed ({$response->status()}): " . $response->body(),
                $response->status()
            );
        }

        $data = $response->json();

        Cache::put($cacheKey, $data, now()->addMinutes(5));

        return $data;
    }
}

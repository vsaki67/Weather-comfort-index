<?php

namespace App\Services;

class CityService
{
    public function getCityCodes(): array
    {
        $path = storage_path('app/data/cities.json');

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        return collect($data['List'] ?? [])
            ->pluck('CityCode')
            ->toArray();
    }
}

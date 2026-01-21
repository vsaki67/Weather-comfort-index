<?php

namespace App\Services;

class ComfortIndexService
{
    /**
     * Compute comfort index (0–100).
     *
     * Inputs expected from OpenWeather response.
     */
    public function calculate(array $weather): float
    {
        // Temperature (Kelvin → Celsius)
        $tempC = $weather['main']['temp'] - 273.15;

        // Humidity (%)
        $humidity = $weather['main']['humidity'];

        // Wind speed (m/s)
        $windSpeed = $weather['wind']['speed'];

        /**
         * Simple, explainable formula:
         *
         * - Ideal temperature ≈ 22°C
         * - Lower humidity = more comfortable
         * - Moderate wind = comfortable
         */

        // Temperature score (0–40)
        $tempScore = max(0, 40 - abs($tempC - 22) * 2);

        // Humidity score (0–30)
        $humidityScore = max(0, 30 - ($humidity - 40) * 0.5);

        // Wind score (0–30)
        $windScore = max(0, 30 - abs($windSpeed - 3) * 3);

        $score = $tempScore + $humidityScore + $windScore;

        return round(min(100, max(0, $score)), 2);
    }
}

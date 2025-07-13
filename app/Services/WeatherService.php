<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
class WeatherService
{
    protected string $baseUrl = 'https://api.open-meteo.com/v1/forecast';

    public function fetchWeatherData(float $latitude, float $longitude): array
    {
        $cacheKey = "weather_{$latitude}_{$longitude}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($latitude, $longitude) {
            $response = Http::get($this->baseUrl, [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'current_weather' => true,
                'hourly' => implode(',', [
                    'temperature_2m',
                    'apparent_temperature',
                    'weathercode',
                    'wind_speed_10m',
                    'relative_humidity_2m',
                    'precipitation'
                ]),
                'timezone' => 'auto',
            ]);

            if (!$response->successful()) {
                return ['error' => 'Failed to fetch weather data.'];
            }

            $data = $response->json();

            $times = $data['hourly']['time'] ?? [];

            return [
                'current' => [
                    'temperature' => $data['current_weather']['temperature'] ?? null,
                    'time' => $data['current_weather']['time'] ?? null,
                ],
                'forecast' => collect($times)->map(function ($time, $i) use ($data) {
                    return [
                        'time' => $time,
                        'temperature' => $data['hourly']['temperature_2m'][$i] ?? null,
                        'apparent_temperature' => $data['hourly']['apparent_temperature'][$i] ?? null,
                        'weather_code' => $data['hourly']['weathercode'][$i] ?? null,
                        'wind_speed' => $data['hourly']['wind_speed_10m'][$i] ?? null,
                        'humidity' => $data['hourly']['relative_humidity_2m'][$i] ?? null,
                        'precipitation' => $data['hourly']['precipitation'][$i] ?? null,
                    ];
                })->values(),
            ];
        });
    }
}

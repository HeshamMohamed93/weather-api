<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'current' => [
                'temperature' => $this['current']['temperature'],
                'time' => $this['current']['time'],
            ],
            'forecast' => collect($this['forecast'])->map(function ($hour) {
                return [
                    'time' => $hour['time'],
                    'temperature' => $hour['temperature'],
                    'apparent_temperature' => $hour['apparent_temperature'],
                    'weather_code' => $hour['weather_code'],
                    'wind_speed' => $hour['wind_speed'],
                    'humidity' => $hour['humidity'],
                    'precipitation' => $hour['precipitation'],
                ];
            }),
        ];
    }
}

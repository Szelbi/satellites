<?php
declare(strict_types=1);

namespace App\Dto;

readonly class WeatherApiResponseDto
{
    public function __construct(
        public string $city,
        public float $temperatureC,
        public float $windSpeedKph,
        public string $windDirection,
        public string $conditionText,
        public float $humidity,
        public float $feelsLikeC,
        public string $country,
        public float $pressureMb,
        public string $lastUpdated,
        public string $requestTime,
    ) {
    }
}


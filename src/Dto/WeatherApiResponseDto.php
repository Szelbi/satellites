<?php
declare(strict_types=1);

namespace App\Dto;

readonly class WeatherApiResponseDto
{
    public function __construct(
        private string $city,
        private float $temperatureC,
        private float $windSpeedKph,
        private string $windDirection,
        private string $conditionText,
        private float $humidity,
        private float $feelsLikeC,
        private string $country,
        private float $pressureMb,
        private string $lastUpdated,
    ) {
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getTemperatureC(): float
    {
        return $this->temperatureC;
    }

    public function getWindSpeedKph(): float
    {
        return $this->windSpeedKph;
    }

    public function getWindDirection(): string
    {
        return $this->windDirection;
    }

    public function getConditionText(): string
    {
        return $this->conditionText;
    }

    public function getHumidity(): float
    {
        return $this->humidity;
    }

    public function getFeelsLikeC(): float
    {
        return $this->feelsLikeC;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getPressureMb(): float
    {
        return $this->pressureMb;
    }

    public function getLastUpdated(): string
    {
        return $this->lastUpdated;
    }
}


<?php
declare(strict_types=1);

namespace App\Service;

use App\Dto\WeatherApiResponseDto;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class WeatherApiService
{
    public function __construct(
        private HttpClientInterface $client,
        private string $weatherApiKey,
    ) {
    }

    public function getWeatherDataForCity(string $city): ?WeatherApiResponseDto
    {
        $response = $this->client->request('GET', 'https://api.weatherapi.com/v1/current.json', [
            'query' => [
                'key' => $this->weatherApiKey,
                'q' => $city,
                'aqi' => 'no',
            ],
        ]);

        $data = $response->toArray();

        if (empty($data)) {
            return null;
        }

        return new WeatherApiResponseDto(
            $data['location']['name'],
            $data['current']['temp_c'],
            $data['current']['wind_kph'],
            $data['current']['wind_dir'],  // kierunek wiatru
            $data['current']['condition']['text'],
            $data['current']['humidity'],
            $data['current']['feelslike_c'],  // Odczuwalna temperatura
            $data['location']['country'],
            $data['current']['pressure_mb'],  // Ciśnienie atmosferyczne
            $data['current']['last_updated']
        );

    }
}


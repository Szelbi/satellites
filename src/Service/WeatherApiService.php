<?php
declare(strict_types=1);

namespace App\Service;

use App\Dto\WeatherApiResponseDto;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class WeatherApiService
{
    private const URL = 'https://api.weatherapi.com/v1/current.json';

    public function __construct(
        private HttpClientInterface $client,
        private string $weatherApiKey,
    ) {
    }

    public function getWeatherDataForCity(string $city, bool $isCurl = false): ?WeatherApiResponseDto
    {
        /** TODO Ports and Adapters??? */
        if ($isCurl) {
            $data = $this->getFromCurl($city);
        } else {
            $data = $this->getFromSymfonyClient($city);
        }

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


    /**
     * @param string $city
     * @return mixed
     */
    public function getFromCurl(string $city): mixed
    {
        $apiKey = $this->weatherApiKey;
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => self::URL . "?key=$apiKey&q=$city&aqi=no",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    }

    /**
     * @param string $city
     * @return array
     */
    public function getFromSymfonyClient(string $city): array
    {
        $response = $this->client->request('GET', self::URL, [
            'query' => [
                'key' => $this->weatherApiKey,
                'q' => $city,
                'aqi' => 'no',
            ],
        ]);

        return $response->toArray();
    }
}


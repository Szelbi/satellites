<?php
declare(strict_types=1);

namespace App\Service;

use App\Dto\WeatherApiResponseDto;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @throws BadRequestHttpException
    */
    public function getFromCurl(string $city): array
    {
        $apiKey = $this->weatherApiKey;
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => self::URL . "?key=$apiKey&q=$city&aqi=no",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_HTTPGET => true,
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response, true);

        if (isset($response['error'])) {
            throw new BadRequestHttpException('An error occurred: ' . $response['error']['message'], null, $response['error']['code']);
        }

        return $response;
    }

    /**
     * @throws BadRequestHttpException
     */
    public function getFromSymfonyClient(string $city): array
    {
        try {
            $response = $this->client->request('GET', self::URL, [
                'query' => [
                    'key' => $this->weatherApiKey,
                    'q' => $city,
                    'aqi' => 'no',
                ],
            ]);
            return $response->toArray();
        } catch (ClientException $e) {
            throw new BadRequestHttpException('An error occurred: ' . $e->getMessage(), null, $e->getCode());
        }

    }
}


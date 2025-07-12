<?php

namespace App\Controller;

use App\Service\WeatherApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/index', name: 'weather_index')]
    public function index(WeatherApiService $service): Response
    {
        $weatherData = $service->getWeatherDataForCity('Tychy', isCurl: true);

        return $this->render('weather/weather.html.twig', [
            'weatherData' => $weatherData,
            'requestTime' => date('Y-m-d H:i:s'),
        ]);
    }

    #[Route('/weather/update', name: 'weather_update', methods: ['GET'])]
    public function update(WeatherApiService $service): JsonResponse
    {
        $weatherData = $service->getWeatherDataForCity('Tychy');

        return new JsonResponse([
            'city' => $weatherData->city,
            'temperatureC' => $weatherData->temperatureC,
            'feelsLikeC' => $weatherData->feelsLikeC,
            'windSpeedKph' => $weatherData->windSpeedKph,
            'windDirection' => $weatherData->windDirection,
            'conditionText' => $weatherData->conditionText,
            'humidity' => $weatherData->humidity,
            'pressureMb' => $weatherData->pressureMb,
            'lastUpdated' => $weatherData->lastUpdated,
            'requestTime' => date('Y-m-d H:i:s'),
        ]);
    }
}

<?php

namespace App\Weather\UserInterface\Controller;

use App\Weather\Application\WeatherApiHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/index', name: 'weather_index')]
    public function index(WeatherApiHandler $service): Response
    {
        $weatherData = $service->getWeatherDataForCity('Tychy', isCurl: true);

        return $this->render('weather/weather.html.twig', [
            'weatherData' => $weatherData,
            'requestTime' => date('Y-m-d H:i:s'),
        ]);
    }

    #[Route('/weather/update', name: 'weather_update', methods: ['GET'])]
    public function update(WeatherApiHandler $service): JsonResponse
    {
        $weatherData = $service->getWeatherDataForCity('Tychy');

        return $this->json($weatherData);
    }
}

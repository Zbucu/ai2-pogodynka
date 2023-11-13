<?php

namespace App\Controller;

use App\Entity\City;
use App\Repository\WeatherDataRepository;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{name}', name: 'app_weather', requirements: ['city' => '[a-zA-Z]+'])]
    public function city(City $city, WeatherUtil $util): Response
    {

        $weatherData = $util->getWeatherForCity($city);

        return $this->render('weather/city.html.twig', [
            'city' => $city,
            'weatherData' => $weatherData,
        ]);
    }
}

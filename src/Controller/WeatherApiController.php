<?php

namespace App\Controller;

use App\Entity\WeatherData;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpFoundation\Response;

class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(
        WeatherUtil $util,
        #[MapQueryParameter('name')] string $name,
        #[MapQueryParameter('country_code')] string $countryCode,
        #[MapQueryParameter('format')] string $format,
        #[MapQueryParameter('twig')] bool $twig = false,
    ): Response
    {
        $weatherData = $util->getWeatherForCountryCodeAndName($countryCode, $name);
        if ($format === 'csv') {
            if ($twig) {
                return $this->render('weather_api/index.csv.twig', [
                    'name' => $name,
                    'countryCode' => $countryCode,
                    'weatherData' => $weatherData,
                ]);
            } else {
                $csv = "name,country_code,date,temperature_in_celsius,temperature_in_fahrenheit\n";
                $csv .= implode(
                    "\n",
                    array_map(fn(WeatherData $wd) => sprintf(
                        '%s,%s,%s,%s,%s',
                        $name,
                        $countryCode,
                        $wd->getDate()->format('Y-m-d'),
                        $wd->getTemperatureInCelsius(),
                        $wd->getTemperatureInFahrenheit(),
                    ), $weatherData)
                );
                return new Response($csv, 200, [
                ]);
            }
        } else {
            if ($twig) {
                return $this->render('weather_api/index.json.twig', [
                    'name' => $name,
                    'countryCode' => $countryCode,
                    'weatherData' => $weatherData,
                ]);
            } else {
                return $this->json([
                    'name' => $name,
                    'country_code' => $countryCode,
                    'weather_data' => array_map(fn(WeatherData $wd) => [
                        'date' => $wd->getDate()->format('Y-m-d'),
                        'temperature_in_celsius' => $wd->getTemperatureInCelsius(),
                        'temperature_in_fahrenheit' => $wd->getTemperatureInFahrenheit(),
                    ], $weatherData),
                ]);
            }
        }
    }
}

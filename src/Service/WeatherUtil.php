<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\City;
use App\Entity\WeatherData;
use App\Repository\CityRepository;
use App\Repository\WeatherDataRepository;

class WeatherUtil
{
    public function __construct(
        private readonly CityRepository $cityRepository,
        private readonly WeatherDataRepository $weatherDataRepository,
    )
    {
    }
    /**
     * @return WeatherData[]
     */
    public function getWeatherForCity(City $city): array
    {
        $weatherData = $this->weatherDataRepository->findByCity($city);
        return $weatherData;
    }

    /**
     * @return WeatherData[]
     */
    public function getWeatherForCountryCodeAndName(string $countryCode, string $name): array
    {
        $city = $this->cityRepository->findOneBy([
            'countryCode' => $countryCode,
            'name' => $name,
        ]);

        $weatherData = $this->getWeatherForCity($city);

        return $weatherData;
    }
}

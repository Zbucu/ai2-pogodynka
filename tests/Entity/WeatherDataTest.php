<?php

namespace App\Tests\Entity;

use App\Entity\WeatherData;
use PHPUnit\Framework\TestCase;

class WeatherDataTest extends TestCase
{
    /**
     * @dataProvider dataGetTemperatureInFahrenheit
     */
    public function testGetTemperatureInFahrenheit($celsius, $expectedFahrenheit): void
    {
        $weatherData = new WeatherData();

//        $weatherData->setTemperatureInCelsius('0');
//        $this->assertEquals(32, $weatherData->getTemperatureInFahrenheit());
//        $weatherData->setTemperatureInCelsius('-100');
//        $this->assertEquals(-148, $weatherData->getTemperatureInFahrenheit());
//        $weatherData->setTemperatureInCelsius('100');
//        $this->assertEquals(212, $weatherData->getTemperatureInFahrenheit());

        $weatherData->setTemperatureInCelsius($celsius);
        $this->assertEquals($expectedFahrenheit, $weatherData->getTemperatureInFahrenheit(),
            "Expected $expectedFahrenheit Fahrenheit for $celsius Celsius,
             got {$weatherData->getTemperatureInFahrenheit()}");
    }

    public function dataGetTemperatureInFahrenheit(): array
    {
        return [
            ['25', 77],
            ['0', 32],
            ['-10', 14],
            ['15.5', 59.9],
            ['30.7', 87.26],
            ['-5.2', 22.64],
            ['8', 46.4],
            ['42.3', 108.14],
            ['-20', -4],
            ['18.9', 66.02],
        ];
    }

}

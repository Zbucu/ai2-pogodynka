<?php

namespace App\Command;

use App\Repository\CityRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:name',
    description: 'Add a short description for your command',
)]
class WeatherNameCommand extends Command
{
    public function __construct(
        private readonly CityRepository $cityRepository,
        private readonly WeatherUtil $weatherUtil,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('country_code', InputArgument::REQUIRED, 'Country Code')
            ->addArgument('city_name', InputArgument::REQUIRED, 'City name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $countryCode = $input->getArgument('country_code');
        $name = $input->getArgument('city_name');

        $weatherData = $this->weatherUtil->getWeatherForCountryCodeAndName($countryCode, $name);
        $io->writeln(sprintf('City: %s', $name));
        foreach ($weatherData as $weatherSingleData) {
            $io->writeln(sprintf("\t%s: %s",
                $weatherSingleData->getDate()->format('Y-m-d'),
                $weatherSingleData->getTemperatureInCelsius()
            ));
        }

        return Command::SUCCESS;
    }
}

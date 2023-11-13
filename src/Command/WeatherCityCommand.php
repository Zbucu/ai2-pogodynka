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
    name: 'weather:city',
    description: 'Add a short description for your command',
)]
class WeatherCityCommand extends Command
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
        $this->addArgument('id', InputArgument::REQUIRED, 'City ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $cityId = $input->getArgument('id');
        $city = $this->cityRepository->find($cityId);

        $weatherData = $this->weatherUtil->getWeatherForCity($city);
        $io->writeln(sprintf('City: %s', $city->getName()));
        foreach ($weatherData as $weatherSingleData) {
            $io->writeln(sprintf("\t%s: %s",
                $weatherSingleData->getDate()->format('Y-m-d'),
                $weatherSingleData->getTemperatureInCelsius()
            ));
        }

        return Command::SUCCESS;
    }
}

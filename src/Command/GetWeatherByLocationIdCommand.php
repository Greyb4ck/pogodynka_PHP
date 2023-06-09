<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'getWeatherByLocationId',
    description: 'Add a short description for your command',
)]
class GetWeatherByLocationIdCommand extends Command
{
    public function __construct(WeatherUtil $weatherUtil, string $name = null)
    {
        $this->weatherUtil = $weatherUtil;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('location_id', InputArgument::REQUIRED,
                'Id of location for which to get the measurements')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $locationId = $input->getArgument('location_id');

        $measurements = $this->weatherUtil->getWeatherForLocationId($locationId);
        foreach ($measurements as $measurement)
            $io->text($measurement);

        return Command::SUCCESS;
    }
}

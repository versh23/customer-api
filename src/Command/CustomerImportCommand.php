<?php

declare(strict_types=1);

namespace App\Command;

use App\Importer\CustomerImporter;
use App\Importer\Nationality;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:customer:import',
    description: 'Add a short description for your command',
)]
class CustomerImportCommand extends Command
{
    public function __construct(
        private CustomerImporter $importer
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(name: 'limit', mode: InputArgument::OPTIONAL, default: 100);
        $this->addArgument(name: 'nationality', mode: InputArgument::OPTIONAL, default: Nationality::AU);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->info('Start importing');

        try {
            $this->importer->import($input->getArgument('limit'), $input->getArgument('nationality'));
        } catch (\Throwable $exception) {
            $io->error(sprintf('Error: %s', $exception->getMessage()));

            return Command::FAILURE;
        }

        $io->success('Successfully imported');

        return Command::SUCCESS;
    }
}

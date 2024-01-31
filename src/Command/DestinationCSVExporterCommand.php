<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Contracts\HttpClient\HttpClientInterface;


#[AsCommand(
    name: 'app:destination-export-csv',
    description: 'Export destinations in CSV file.',
    hidden: false,
    aliases: []
)]
class DestinationCSVExporterCommand extends Command
{
    public function __construct(private HttpClientInterface $httpClient, #[Autowire('%exports_dir%')] private string $exportsDir)
    {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->setDescription('Export destinations in CSV file.')
            ->setHelp('This command allows you to export all destinations in a CSV file.')
            ->addArgument('filename', InputArgument::REQUIRED,'the name of the file')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            "Export destinations",
            "==================="
        ]);

        $response = $this->httpClient->request(
            'GET',
            'http://localhost:8000/api/destinations'
        );

        //TODO handle http responses
        if($response->getStatusCode() != Response::HTTP_OK) {
            $output->writeln("An error occurred while retrieving data.");
            return Command::FAILURE;
        }

        $destinations = $response->toArray();
        
        $csvEncoder = new CsvEncoder();
        $encoded = $csvEncoder->encode($destinations, 'csv', []);

        try {
            $filename = $this->exportsDir . \DIRECTORY_SEPARATOR . $input->getArgument('filename') . '.csv';
            $file = new \SplFileObject($filename, "w");
        } catch(\Exception $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }

        $file->fwrite($encoded);
        $file->fflush();

        $output->writeln("Your export has been completed successfully in : " . $filename);
        return Command::SUCCESS;
    }
}
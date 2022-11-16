<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Message\DataNotification;

class NewsParseCommand extends Command
{
    protected static $defaultName = 'news:parse';
    protected static $defaultDescription = 'To parse news from an API';
    private $http;
    private $bus;

    public function __construct(HttpClientInterface $http, MessageBusInterface $bus)
    {
        parent::__construct();
        $this->http = $http;
        $this->bus = $bus;
    }

    protected function configure(): void
    {
        // $this
        //     ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
        //     ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        // ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->note(sprintf('Parsing process started'));

        $response = $this->http->request(
            'GET',
            'https://jsonplaceholder.typicode.com/posts',
            [
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ],
        );

        $data = $response->toArray(); // getting response

        foreach($data as $item)
        {   
            $article = new \stdClass;
            $article->title = $item['title'];
            $article->shortDescription = $item['body'];
            $article->picture = 'image_link';

            $this->bus->dispatch(new DataNotification($article));
            $io->note(sprintf("new article added to the queue")); 
        }   

        $io->success('Parsed successfully');

        return Command::SUCCESS;
    }
}

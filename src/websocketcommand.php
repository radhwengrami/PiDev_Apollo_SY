<?php

namespace App;

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use App\MessageHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface; // Assurez-vous d'importer l'EntityManagerInterface

class websocketcommand extends Command
{
    protected static $defaultName = "run:websocket-server";

    // Injectez EntityManagerInterface dans le constructeur
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = 3001;
        $output->writeln("Starting server on port " . $port);

        // Instanciez MessageHandler en lui passant l'EntityManagerInterface
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new MessageHandler($this->entityManager)
                )
            ),
            $port
        );
        $server->run();
        return 0;
    }
}

?>

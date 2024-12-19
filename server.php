<?php

use MyApp\Jeu;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Partie;



// Inclusion de l'autoloader de Composer pour charger les dépendances
require __DIR__ ."/vendor/autoload.php";

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Jeu()
        )
    ),
    // Port d'écoute du serveur WebSocket
    8080
);

echo "Serveur WebSocket démarré sur http://127.0.0.1:8080\n";

$server->run();


?>
<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;


class Jeu implements MessageComponentInterface {
    
    protected $clients;
    private $partie;
    
    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->partie = new Partie();
    }


    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Nouvelle connexion! ({$conn->resourceId})\n";
        $j = new Joueur( $conn->resourceId,100,10,0);
        $this->partie->ajouterJoueur($j);
        echo "HP du monstre : {$this->partie->getMonstre()->getHp()}";



    }


    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connexion %d envoi le message "%s" à %d client(s)' . "\n"
            , $from->resourceId, $msg, $numRecv);
    
            
        $j = $this->partie->getOneJoueurById($from->resourceId);    
        $action= json_decode($msg, true)['action'];
    

        if ($action == "attaque"){
            echo("aaaaaaaaCtion");

        }
        $strClient= "";
        
        $this->partie->getMonstre()->setHp($this->partie->getMonstre()->getHp() - $j->getAtt());
        echo "HP du monstre : {$this->partie->getMonstre()->getHp()}";

        foreach ($this->clients as $client) {
    
            $msg = sprintf('{"action":"attaque", "from": %d, "att" : %s, Hp du monstre : %d}', $j->getId(), $j->getAtt(), $this->partie->getMonstre()->getHp() );

            if ($from !== $client) {
                $client->send($msg);
                $strClient .= var_dump($client->resourceId);
            }
        }
        echo sprintf("%s", $strClient);
    }

    
    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connexion {$conn->resourceId} déconnectée\n";
    }


    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Une erreur est survenue : {$e->getMessage()}\n";
        $conn->close();
    }


    
    
    
    
}
?>
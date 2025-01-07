<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;


class Jeu implements MessageComponentInterface {
    
    protected $clients;
    private $partie;
    private $playerTurn ;
    private $playerTurnList =[];
    

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->partie = new Partie();
    }


    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Nouvelle connexion! ({$conn->resourceId})\n";
        $j = new Joueur( $conn->resourceId,100,10,0,1);
        $this->partie->ajouterJoueur($j);
        echo "HP du monstre : {$this->partie->getMonstre()->getHp()}";
        var_dump($this->partie);
        if($this->playerTurn == null){
            // $this->playerTurn = $this->partie->playerTurn();
            $this->playerTurn = $conn;
            $conn->send('your turn');
            $this->partie->getMonstre()->setFocus($j);

        }
        // elseif($this->playerTurnList==[]){
        //     $this->playerTurnList = $this->clients;
        // }
        else{
            $this->playerTurnList[]=$conn;
            echo(count($this->playerTurnList));
        }
        
    }



    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connexion %d envoi le message "%s" à %d client(s)' . "\n"
            , $from->resourceId, $msg, $numRecv);
    
        

        $j = $this->partie->getOneJoueurById($from->resourceId);
        $action= json_decode($msg, true)['action'];
    

        if ($action == "attaque"){
            echo("aaaaaaaaCtion");
            $this->partie->getMonstre()->setHp($this->partie->getMonstre()->getHp() - $j->getAtt());
            echo "HP du monstre : {$this->partie->getMonstre()->getHp()}";

        }
        
        
        else if ($action == "SuperAttaque"){
            echo("SUUUUUUUUUUUUUUUUUUUUUUUUUUPER ACTION");
            $this->partie->getMonstre()->setHp($this->partie->getMonstre()->getHp() - 100000);
            echo "HP du monstre : {$this->partie->getMonstre()->getHp()}";
        }

        else if ($action == "Provoquer"){
            echo("AAAAAAAAAAAAAAAAAAAA ATTAQUE MOI");
            $this->partie->getMonstre()->setFocus($j);
            echo "HP du monstre : {$this->partie->getMonstre()->getHp()}";
        }

        else if ($action == "Heal"){
            echo("A LAIDE JE ME SOIGNE");
            $j->setHp($j->getHp() + $j->getAtt());
            echo "HP du monstre : {$this->partie->getMonstre()->getHp()}";
        }
        
        $strClient= "";
        echo(gettype($this->partie->getMonstre()->getHp()));
        echo($this->partie->getMonstre()->getHp() <= 0);
        $hpM = $this->partie->getMonstre()->getHp() ;  

        if($hpM<= 0){

            $this->partie->setMonstre();
            $this->partie->nextNiveau();
        
            foreach ($this->clients as $client) {
                

                $msg = sprintf('Monstre tué !! Niveau : %d !! Un nouveau Monstre apparaît : Hp du monstre : %d',  $this->partie->getNiveau(), $this->partie->getMonstre()->getHp());
                $this->partie->getMonstre()->setFocus($j);
                $client->send($msg);
                $strClient .= var_dump($client->resourceId);
        
            }

        }
        else{
    
            foreach ($this->clients as $client) {
                
                $msg = sprintf('{"action": %s, "from": %d, "att" : %s, Hp du monstre : %d, hp du joueur : %d}',$action, $j->getId(), $j->getAtt(), $this->partie->getMonstre()->getHp(), $j->getHp());
                
                // if ($from !== $client) {  //On peut rajouter un vous avez attaqué voir écrire directement sans passer par la webso
                    $client->send($msg);
                    $strClient .= var_dump($client->resourceId);
                // }
            }
        }
        echo sprintf("%s", $strClient);

        if($this->playerTurnList==[]){
            $this->partie->getMonstre()->attaque();
            foreach ($this->clients as $client) {
                $this->playerTurnList[] = $client;
                $client->send("Le monstre attaque");
            }




        };
        echo(count($this->playerTurnList));
        $this->playerTurn = array_pop($this->playerTurnList);
        echo(gettype($this->playerTurn));
        $this->playerTurn->send('your turn');
    }

    
    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connexion {$conn->resourceId} déconnectée\n";
        if($this->playerTurn==$conn){
            if($this->playerTurnList==[]){
                $this->partie->getMonstre()->attaque();
                foreach ($this->clients as $client) {
                    $this->playerTurnList[] = $client;
                    $client->send("Le monstre attaque");
                }

            }
        }
        
        $index = array_search($conn, $this->playerTurnList, true);

        if ($index !== false) {
            unset($this->playerTurnList[$index]);
        }
    }


    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Une erreur est survenue : {$e->getMessage()}\n";
        $conn->close();
    }



    
    
}
?>
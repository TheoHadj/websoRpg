<?php
namespace MyApp;

class Joueur extends Entite {

    private int $ordre;


    function nextLvl():void {
        $this->setAtt($this->getAtt() +1);
        // $this->setDef($this->getDef());
        $this->setHp($this->getHp() +5);
    }

    

}
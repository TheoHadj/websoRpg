<?php
namespace MyApp;


class Monstre extends Entite {
    
    private Joueur $actualFocus;


    public function __construct(int $lvl) {
        $this->setID(0);
        $this->setHp(50 + 10* $lvl);
        $this->setAtt(10 + 2* $lvl);
        $this->setDef(0);
    }
    public function getFocus(): Joueur {
        return $this->actualFocus;
    }

    public function setFocus(Joueur $actualFocus): void {
        $this->actualFocus = $actualFocus;
    }    

    public function attaque():void{
        $val = $this->actualFocus->getHp() - ($this->getAtt() - $this->actualFocus->getDef());
        $this->actualFocus->setHp(hp: $val);

    }

}
<?php
namespace MyApp;


use Ratchet\ConnectionInterface;

abstract class Entite {
    
    private int $id;
    private int $hp;
    private int $att;
    private int $def;
    private int $lvl;

    public function __construct(int $id, int $hp, int $att, int $def,int $lvl) {
        $this->id = $id;
        $this->hp = $hp;
        $this->att = $att;
        $this->def = $def;
        $this->lvl = $lvl;
    }

    public function getId(): int {
        return $this->id;
    }
    public function setID(int $id): void {
        $this->id = $id;
    }

    public function getHp(): int {
        return $this->hp;
    }

    public function getAtt(): int {
        return $this->att;
    }

    public function getDef(): int {
        return $this->def;
    }

    public function setHp(int $hp): void {
        $this->hp = $hp;
    }

    public function setAtt(int $att): void {
        $this->att = $att;
    }

    public function setDef(int $def): void {
        $this->def = $def;
    }



    public function getLvl(): int {
        return $this->lvl;
    }

    public function nextLvl(): void {
        $this->lvl ++;
    }



}
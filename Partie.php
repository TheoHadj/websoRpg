<?php

namespace MyApp;

// use Joueur;
use Ratchet\ConnectionInterface;


// include("Joueur.php");

class Partie{
    private array $listJoueur = [];
    private array $listJoueurOrdre = [];
    private int $niveau = 1;
    private int $nombreJoueur = 0;
    private bool $active = true;

    private Monstre $monstre;

    public function __construct() {

        $this->setMonstre();
    }

    
    public function getListJoueur(): array {
        return $this->listJoueur;
    }

    public function getListJoueurOrdre(): array {
        return $this->listJoueurOrdre;
    }

    public function getNiveau(): int {
        return $this->niveau;
    }

    public function getActive(): bool{
        return $this->active;
    }

    public function getMonstre(): Monstre{
        return $this->monstre;
    }

    public function getOneJoueurById(int $id): ?Joueur{
        foreach ($this->listJoueur as $joueur) {
            if ($joueur->getId() === $id) {
                return $joueur;
            }
        }

        return null;
    }

    public function setListJoueur(array $listJoueur): void {
        $this->listJoueur = $listJoueur;
        $this->listJoueurOrdre = $listJoueur;
    }

    public function setNiveau(int $niveau): void {
        $this->niveau = $niveau;
    }
    public function nextNiveau(): void {
        $this->niveau ++;
    }

    public function setMonstre(): void {
        $this->monstre = new Monstre($this->niveau);
    }

    public function GameOver(bool $active): void {
        $this->active = $active;
    }

    public function ajouterJoueur(Joueur $joueur): void {
        $this->listJoueur[] = $joueur;
        $this->listJoueurOrdre[] = $joueur;
        $this->nombreJoueur +=1;
    }

    public function retirerJoueur(Joueur $joueur): void {
        $this->listJoueur = array_filter(
            $this->listJoueur,
            fn($j) => $j !== $joueur
        );
    }

    public function playerTurn(): Joueur {
        $tmp = array_pop($this->listJoueurOrdre);
        return $tmp;
    }
}
    
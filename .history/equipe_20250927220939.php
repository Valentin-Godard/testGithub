<?php


require_once "match.php";
require_once "joueur.php";

class equipe{
    
    private string $nom;
    private array $joueurs = []; // tableau de joueurs
    private array $matchs = [];  // tableau de matchs

    public function __construct(string $nom) {
        $this->nom = $nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getNom(){
        $this->nom;
    }

    public function ajouterJoueur(joueur $joueur, string $role) {
        $this->joueurs[] = [
            "joueur" => $joueur,
            "role" => $role
        ];
    }

    public function ajouterMatch(atchFoot $match): void {
        $this->matchs[] = $match;
    }

    public function getJoueurs(): array {
        return $this->joueurs;
    }

}


<?php


require_once "joueur.php";
require_once "match.php";

class equipe{
    
    private string $nom;

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

    public function ajouterMatch(match $match) {
        $this->match[] = $match;
    }

    public function getJoueurs(): array {
        return $this->joueurs;
    }
}


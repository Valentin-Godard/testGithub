<?php


require_once "Match.php";
require_once "Joueur.php";

class Equipe{
    
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

    public function ajouterMatch(matchFoot $match): void {
        $this->matchs[] = $match;
    }

    public function getJoueurs(): array {
        return $this->joueurs;
    }

}

/*
$equipe1 = new Equipe("PSG");
$equipe1->ajouterJoueur($j1, "Attaquant");
$equipe1->ajouterJoueur($j2, "Milieu");
$equipe1->ajouterJoueur($j3, "Ailier");
*/
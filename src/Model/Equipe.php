<?php

namespace RedwaneValentin\Foot2Club\Model;

use RedwaneValentin\Foot2Club\Model\MatchFoot;
use RedwaneValentin\Foot2Club\Model\Joueur;

class Equipe{
    
    private ?int $id; 
    private string $nom;
    private array $joueurs = []; // tableau de joueurs
    private array $matchs = [];  // tableau de matchs

    
    public function __construct(string $nom, ?int $id = null) {
        $this->nom = $nom;
        $this->id = $id;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getNom(){
        return $this->nom; 
    }

    public function getId(): ?int { 
        return $this->id;
    }

    public function ajouterJoueur(Joueur $joueur, string $role) {
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
<?php


require_once "match.php";
require_once "joueur.php";

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

    

}


<?php

class equipe {

    private string $equipe1Score;

    private string $equipe2Score;

    private DateTime $date;

    private 

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

<?php

class equipe {

    private string $equipe1Score;

    private string $equipe2Score;

    private DateTime $date;

    private string $city;

    public function __construct(string $equipe1Score, string $equipe2Score, DateTime $date, string $city) {
        $this->equipe1Score = $equipe1Score;
        $this->equipe2Score = $equipe2Score;
        $this->date = $date;
        $this->city = $equipe1Score;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getNom(){
        $this->nom;
    }
}

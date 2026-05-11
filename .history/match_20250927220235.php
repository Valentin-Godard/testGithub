<?php

require_once ".php";
require_once "clubOppose.php";

class equipe {

    private string $equipe1Score;

    private string $equipe2Score;

    private DateTime $date;

    private string $city;

    public function __construct(string $equipe1Score, string $equipe2Score, DateTime $date, string $city) {

        $this->equipe1Score = $equipe1Score;
        $this->equipe2Score = $equipe2Score;
        $this->date = $date;
        $this->city = $city;
    }

    public function getEquipe1Score(): string {
        return $this->equipe1Score;
    }

    public function setEquipe1Score(string $equipe1Score): void {
        $this->equipe1Score = $equipe1Score;
    }

    public function getEquipe2Score(): string {
        return $this->equipe2Score;
    }

    public function setEquipe2Score(string $equipe2Score): void {
        $this->equipe2Score = $equipe2Score;
    }

    public function getDate(): DateTime {
        return $this->date;
    }

    public function setDate(DateTime $date): void {
        $this->date = $date;
    }

    public function getCity(): string {
        return $this->city;
    }

    public function setCity(string $city): void {
        $this->city = $city;
    }
}

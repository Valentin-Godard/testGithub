<?php

class clubOppose{

    public string $adresse;
    
    public string $city;

    public function __construct(string $adresse, string $city) {

        $this->adresse = $adresse;

        $this->city = $city;
    }

    public function getAdresse(): string {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): void {
        $this->adresse = $adresse;
    }

    public function getCity(): string {
        return $this->city;
    }

    public function setCity(string $city): void {
        $this->city = $city;
    }
}
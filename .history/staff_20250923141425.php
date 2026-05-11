<?php

class staff{

    public string $prenom;

    public string $nom;

    public string $anniversaire;

    public string $image;

    public function __construct(string $prenom, string $nom, string $anniversaire, string $image) {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->anniversaire = $anniversaire;
        $this->image = $image;
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function getAnniversaire(): string {
        return $this->anniversaire;
    }

    public function setAnniversaire(string $anniversaire): void {
        $this->anniversaire = $anniversaire;
    }

    public function getImage(): string {
        return $this->image;
    }

    public function setImage(string $image): void {
        $this->image = $image;
    }

}
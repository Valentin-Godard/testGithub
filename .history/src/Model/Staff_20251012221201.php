<?php

namespace App\Model;

class Staff{

    public string $prenom;

    public string $nom;

    public string $image;

    public string $role;

    public function __construct(string $prenom, string $nom, string $image, string $role) {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->image = $image;
        $this->role = $role;
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
        return $this->image;
    }

    public function setRole(string $image): void {
        $this->image = $image;
    }

    public function getImage(): string {
        return $this->role;
    }

    public function setImage(string $role): void {
        $this->role = $role;
    }

}
 /*
$staff1 = new Staff("Jean", "Dupont", "dupont.jpg", "Entraîneur");
*/

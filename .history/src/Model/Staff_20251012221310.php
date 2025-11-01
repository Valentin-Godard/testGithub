<?php
namespace App\Model;

class Staff {
    private string $prenom;
    private string $nom;
    private string $image;
    private string $role;

    public function __construct(string $prenom, string $nom, string $image, string $role) {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->image = $image;
        $this->role = $role;
    }

    public function getPrenom(): string { return $this->prenom; }
    public function setPrenom(string $prenom): void { $this->prenom = $prenom; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }

    public function getImage(): string { return $this->image; }
    public function setImage(string $image): void { $this->image = $image; }

    public function getRole(): string { return $this->role; }
    public function setRole(string $role): void { $this->role = $role; }
}


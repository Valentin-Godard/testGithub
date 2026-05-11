<?php
namespace App\Model;

class Equipe {
    private ?int $id;
    private string $nom;
    private string $ville;
    private string $adresse;

    public function __construct(?int $id, string $nom, string $ville, string $adresse) {
        $this->id = $id;
        $this->nom = $nom;
        $this->ville = $ville;
        $this->adresse=$adresse;
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }

    public function getVille(): string { return $this->ville; }
    public function setVille(string $ville): void { $this->ville = $ville; }
    
}

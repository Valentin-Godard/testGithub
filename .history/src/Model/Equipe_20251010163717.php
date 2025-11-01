<?php
namespace App\Model;

use App\Model\Joueur;
use App\Model\MatchFoot;

class Equipe {
    private ?int $id;
    private string $nom;
    private array $joueurs = [];
    private array $matchs = [];

    public function __construct(?int $id, string $nom) {
        $this->id = $id;
        $this->nom = $nom;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function ajouterJoueur(Joueur $joueur, string $role): void {
        $this->joueurs[] = [
            'joueur' => $joueur,
            'role' => $role
        ];
    }

    public function ajouterMatch(MatchFoot $match): void {
        $this->matchs[] = $match;
    }

    public function getJoueurs(): array {
        return $this->joueurs;
    }

    public function getMatchs(): array {
        return $this->matchs;
    }
}

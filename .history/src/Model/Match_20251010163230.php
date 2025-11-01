<?php
namespace App\Model;

use DateTime;

class MatchFoot {
    private ?int $id;
    private string $equipe1Score;
    private string $equipe2Score;
    private DateTime $date;
    private string $ville;
    private int $equipeId;
    private int $adversaireId;

    public function __construct(
        ?int $id,
        string $equipe1Score,
        string $equipe2Score,
        DateTime $date,
        string $ville,
        int $equipeId = 0,
        int $adversaireId = 0
    ) {
        $this->id = $id;
        $this->equipe1Score = $equipe1Score;
        $this->equipe2Score = $equipe2Score;
        $this->date = $date;
        $this->ville = $ville;
        $this->equipeId = $equipeId;
        $this->adversaireId = $adversaireId;
    }

    public function getId(): ?int { return $this->id; }
    public function getEquipe1Score(): string { return $this->equipe1Score; }
    public function getEquipe2Score(): string { return $this->equipe2Score; }
    public function getDate(): DateTime { return $this->date; }
    public function getVille(): string { return $this->ville; }
    public function getEquipeId(): int { return $this->equipeId; }
    public function getAdversaireId(): int { return $this->adversaireId; }

    public function setEquipe1Score(string $score): void { $this->equipe1Score = $score; }
    public function setEquipe2Score(string $score): void { $this->equipe2Score = $score; }
    public function setDate(DateTime $date): void { $this->date = $date; }
    public function setVille(string $ville): void { $this->ville = $ville; }
    public function setEquipeId(int $id): void { $this->equipeId = $id; }
    public function setAdversaireId(int $id): void { $this->adversaireId = $id; }
}


/*
$match1 = new MatchFoot(3, 1, new DateTime("2025-10-15"), "Paris", $real);
$equipe1->ajouterMatch($match1);
*/
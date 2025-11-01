<?php
namespace App\Model;

use DateTime;

class MatchFoot {
    private ?int $id;
    private int $scoreEquipe;
    private int $scoreEquipeAdv;
    private DateTime $date;
    private int $equipeId;
    private string $ville;
    private int $clubAdvId;

    public function __construct(
        ?int $id,
        int $scoreEquipe,
        int $scoreEquipeAdv,
        DateTime $date,
        int $equipeId,
        string $ville,
        int $clubAdvId
    ) {
        $this->id = $id;
        $this->scoreEquipe = $scoreEquipe;
        $this->scoreEquipeAdv = $scoreEquipeAdv;
        $this->date = $date;
        $this->equipeId = $equipeId;
        $this->ville = $ville;
        $this->clubAdvId = $clubAdvId;
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getScoreEquipe(): int { return $this->scoreEquipe; }
    public function getScoreEquipeAdv(): int { return $this->scoreEquipeAdv; }
    public function getDate(): DateTime { return $this->date; }
    public function getEquipeId(): int { return $this->equipeId; }
    public function getVille(): string { return $this->ville; }
    public function getClubAdvId(): int { return $this->clubAdvId; }

    // Setters
    public function setScoreEquipe(int $score): void { $this->scoreEquipe = $score; }
    public function setScoreEquipeAdv(int $score): void { $this->scoreEquipeAdv = $score; }
    public function setDate(DateTime $date): void { $this->date = $date; }
    public function setEquipeId(int $id): void { $this->equipeId = $id; }
    public function setVille(string $ville): void { $this->ville = $ville; }
    public function setClubAdvId(int $id): void { $this->clubAdvId = $id; }
}

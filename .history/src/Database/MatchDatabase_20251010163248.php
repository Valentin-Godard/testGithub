<?php
namespace App\Database;

use App\Model\MatchFoot;
use PDO;
use DateTime;

class MatchDatabase {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function insert(MatchFoot $match): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO matchs (date_match, ville, score_equipe, score_adverse, equipe_id, club_adverse_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $match->getDate()->format("Y-m-d"),
            $match->getVille(),
            $match->getEquipe1Score(),
            $match->getEquipe2Score(),
            $match->getEquipeId(),
            $match->getAdversaireId()
        ]);
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM matchs"); // attention, table "matchs"

        $matchs = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $matchs[] = new MatchFoot(
                $data['id'],
                $data['score_equipe'],
                $data['score_adverse'],
                new DateTime($data['date_match']),
                $data['ville'],
                $data['equipe_id'],
                $data['club_adverse_id']
            );
        }

        return $matchs;
    }
}

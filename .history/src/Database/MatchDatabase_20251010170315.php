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
            INSERT INTO match (score_equipe, score_equipe_adv, date, equipe_id, ville, clup_adv_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $match->getScoreEquipe(),
            $match->getScoreEquipeAdv(),
            $match->getDate()->format("Y-m-d"),
            $match->getEquipeId(),
            $match->getVille(),
            $match->getClubAdvId()
        ]);
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM match");
        $matchs = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $matchs[] = new MatchFoot(
                $data['id'],
                $data['score_equipe'],
                $data['score_equipe_adv'],
                new DateTime($data['date']),
                $data['equipe_id'],
                $data['ville'],
                $data['clup_adv_id']
            );
        }

        return $matchs;
    }
}

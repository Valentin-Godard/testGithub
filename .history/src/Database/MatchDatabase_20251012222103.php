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
            INSERT INTO matchs (score_equipe, score_equipe_adv, date, equipe_id, ville, club_adv_id)
            VALUES (:scoreEquipe, :scoreAdv, :date, :equipeId, :ville, :clubAdvId)
        ");

        $stmt->execute([
            ':scoreEquipe' => $match->getScoreEquipe(),
            ':scoreAdv' => $match->getScoreEquipeAdv(),
            ':date' => $match->getDate()->format("Y-m-d"),
            ':equipeId' => $match->getEquipeId(),
            ':ville' => $match->getVille(),
            ':clubAdvId' => $match->getClubAdvId()
        ]);
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM matchs");
        $matchs = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $matchs[] = new MatchFoot(
                (int)$data['id'],
                (int)$data['score_equipe'],
                (int)$data['score_equipe_adv'],
                new DateTime($data['date']),
                (int)$data['equipe_id'],
                $data['ville'],
                (int)$data['club_adv_id']
            );
        }

        return $matchs;
    }
}

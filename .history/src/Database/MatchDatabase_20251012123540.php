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
    $stmt = $this->pdo->query("SELECT * FROM matchs");
    $matchs = [];

    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $matchs[] = new MatchFoot(
            $data['id'],
            $data['score_equipe'],
            $data['score_equipe_adv'],
            new DateTime($data['date']),
            $data['equipe_id'],
            $data['ville'],
            $data['club_adv_id'] 
        );
    }

    return $matchs;
}

}

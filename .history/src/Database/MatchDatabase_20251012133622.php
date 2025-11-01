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
            INSERT INTO match (team_score, opponent_score, date, team_id, city, opposing_club_id)
            VALUES (:team_score, :opponent_score, :date, :team_id, :city, :opposing_club_id)
        ");
        $stmt->execute([
            ':team_score' => $match->getTeamScore(),
            ':opponent_score' => $match->getOpponentScore(),
            ':date' => $match->getDate()->format("Y-m-d"),
            ':team_id' => $match->getTeamId(),
            ':city' => $match->getCity(),
            ':opposing_club_id' => $match->getOpposingClubId(),
        ]);
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM match");
        $matches = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $matches[] = new MatchFoot(
                $data['id'],
                $data['team_score'],
                $data['opponent_score'],
                new DateTime($data['date']),
                $data['team_id'],
                $data['city'],
                $data['opposing_club_id']
            );
        }

        return $matches;
    }
}


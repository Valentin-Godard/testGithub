<?php
namespace App\Database;

use PDO;

class JoueurEquipeDatabase {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function insert(int $joueurId, int $equipeId, string $role): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO joueur_ayant_equipe (joueur_id, equipe_id, role)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$joueurId, $equipeId, $role]);
    }
}

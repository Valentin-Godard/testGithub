<?php
namespace App\Database;

use App\Model\Equipe;
use PDO;

class EquipeDatabase {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function insert(Equipe $equipe): void {
        $stmt = $this->pdo->prepare("INSERT INTO equipe (nom) VALUES (?)");
        $stmt->execute([$equipe->getNom()]);
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM equipe");
        $equipes = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $equipes[] = new Equipe($data['id'], $data['nom']);
        }

        return $equipes;
    }

    public function findById(int $id): ?Equipe {
        $stmt = $this->pdo->prepare("SELECT * FROM equipe WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Equipe($data['id'], $data['nom']) : null;
    }

    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM equipe WHERE id = ?");
        $stmt->execute([$id]);
    }
}

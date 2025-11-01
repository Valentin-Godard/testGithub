<?php
namespace App\Database;

use App\Model\Equipe;
use PDO;
use Exception;

class EquipeDatabase {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Insère une équipe dans la table 'equipe'
     * et crée automatiquement un enregistrement correspondant dans 'club_adverse'
     * (avec nom + ville)
     */
    public function insert(Equipe $equipe): void {
        try {
            // Démarrer une transaction pour garder la cohérence des deux insertions
            $this->pdo->beginTransaction();

            // 1️⃣ Insertion dans la table 'equipe' (juste le nom)
            $stmtEquipe = $this->pdo->prepare("
                INSERT INTO equipe (nom)
                VALUES (:nom)
            ");
            $stmtEquipe->execute([
                ':nom' => $equipe->getNom(),
            ]);

            $equipe->setId((int)$this->pdo->lastInsertId());

            // 2️⃣ Insertion dans la table 'club_adverse' (nom + ville)
            $stmtClub = $this->pdo->prepare("
                INSERT INTO club_adverse (nom, ville)
                VALUES (:nom, :ville)
            ");
            $stmtClub->execute([
                ':nom' => $equipe->getNom(),
                ':ville' => $equipe->getVille(),
            ]);

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM equipe");
        $equipes = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Si la table 'equipe' n’a pas de colonne ville, on passe une valeur vide
            $equipes[] = new Equipe($data['id'], $data['nom'], '');
        }

        return $equipes;
    }

    public function findById(int $id): ?Equipe {
        $stmt = $this->pdo->prepare("SELECT * FROM equipe WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Même chose ici : pas de colonne ville → on met une chaîne vide
        return $data ? new Equipe($data['id'], $data['nom'], '') : null;
    }

    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM equipe WHERE id = ?");
        $stmt->execute([$id]);
    }
}


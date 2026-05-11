<?php
namespace App\Database;

use App\Model\Equipe;
use PDO;

class EquipeDatabase {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Ajoute une nouvelle équipe et crée l'entrée dans club_adverse
     */
    public function addEquipeWithClubAdverse(Equipe $equipe, int $club_id): bool {
        try {
            $this->pdo->beginTransaction();

            // 1️⃣ Ajouter l'équipe dans la table "equipes"
            $stmt = $this->pdo->prepare("
                INSERT INTO equipes (nom, club_id) VALUES (:nom, :club_id)
            ");
            $stmt->execute([
                'nom' => $equipe->getNom(),
                'club_id' => $club_id
            ]);

            // Récupérer l'ID de l'équipe créée
            $equipe_id = (int)$this->pdo->lastInsertId();

            // 2️⃣ Récupérer ville et adresse du club
            $stmt2 = $this->pdo->prepare("SELECT ville, adresse FROM clubs WHERE id = :id");
            $stmt2->execute(['id' => $club_id]);
            $club = $stmt2->fetch(PDO::FETCH_ASSOC);

            if (!$club) {
                $this->pdo->rollBack();
                return false;
            }

            // 3️⃣ Ajouter dans club_adverse
            $stmt3 = $this->pdo->prepare("
                INSERT INTO club_adverse (equipe_id, ville, adresse)
                VALUES (:equipe_id, :ville, :adresse)
            ");
            $stmt3->execute([
                'equipe_id' => $equipe_id,
                'ville' => $club['ville'],
                'adresse' => $club['adresse']
            ]);

            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}

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
     * Récupère toutes les équipes avec ville et adresse du club
     * @return Equipe[]
     */
    public function getAll(): array {
        $stmt = $this->pdo->query("
            SELECT e.id AS equipe_id, e.nom AS equipe_nom, c.ville AS club_ville, c.adresse AS club_adresse
            FROM equipes e
            JOIN clubs c ON e.club_id = c.id
            ORDER BY e.nom
        ");

        $equipes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $equipes[] = new Equipe(
                (int)$row['equipe_id'],
                $row['equipe_nom'],
                $row['club_ville'],
                $row['club_adresse']
            );
        }
        return $equipes;
    }

    /**
     * Ajoute une équipe et crée l'entrée correspondante dans club_adverse
     */
    public function addEquipeWithClubAdverse(Equipe $equipe, int $club_id): bool {
        try {
            $this->pdo->beginTransaction();

            // Ajouter l'équipe dans "equipes"
            $stmt = $this->pdo->prepare("INSERT INTO equipes (nom, club_id) VALUES (:nom, :club_id)");
            $stmt->execute([
                'nom' => $equipe->getNom(),
                'club_id' => $club_id
            ]);
            $equipe_id = (int)$this->pdo->lastInsertId();

            // Récupérer ville et adresse du club
            $stmt2 = $this->pdo->prepare("SELECT ville, adresse FROM clubs WHERE id = :id");
            $stmt2->execute(['id' => $club_id]);
            $club = $stmt2->fetch(PDO::FETCH_ASSOC);
            if (!$club) {
                $this->pdo->rollBack();
                return false;
            }

            // Ajouter dans club_adverse
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

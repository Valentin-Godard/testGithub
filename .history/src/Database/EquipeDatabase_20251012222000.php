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

    public function addEquipeWithClubAdverseDirect(Equipe $equipe, string $ville, string $adresse): bool {
    try {
        $this->pdo->beginTransaction();

        // Ajouter le nom dans "equipes"
        $stmt = $this->pdo->prepare("INSERT INTO equipe (nom) VALUES (:nom)");
        $stmt->execute(['nom' => $equipe->getNom()]);
        $equipe_id = (int)$this->pdo->lastInsertId();

        // Ajouter la ville et l'adresse dans "club_adverse"
        $stmt2 = $this->pdo->prepare("
            INSERT INTO club_adverse (id, ville, adresse)
            VALUES (:equipe_id, :ville, :adresse)
        ");
        $stmt2->execute([
            'equipe_id' => $equipe_id,
            'ville' => $ville,
            'adresse' => $adresse
        ]);

        $this->pdo->commit();
        return true;
    } catch (\Exception $e) {
        $this->pdo->rollBack();
        return false;
    }
}

}

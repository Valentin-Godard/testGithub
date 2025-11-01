<?php
namespace App\Database;

use App\Model\Joueur;
use App\Enum\Role;
use PDO;
use DateTime;

class JoueurDatabase {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Ajoute un joueur dans la base
     */
    public function insert(Joueur $joueur): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO joueurs (nom, prenom, date_naissance, photo, role)
            VALUES (:nom, :prenom, :date_naissance, :photo, :role)
        ");

        
            ':nom' => $joueur->getNom(),
            ':prenom' => $joueur->getPrenom(),
            ':date_naissance' => $joueur->getBirthdate()->format("Y-m-d"),
            ':photo' => $joueur->getImage(),
            ':role' => $joueur->getRole()->value
        ]);
    }

    /**
     * Met à jour un joueur existant
     */
    public function update(Joueur $joueur): void {
        $stmt = $this->pdo->prepare("
            UPDATE joueurs
            SET nom = :nom, prenom = :prenom, date_naissance = :date_naissance, photo = :photo, role = :role
            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $joueur->getId(),
            ':nom' => $joueur->getNom(),
            ':prenom' => $joueur->getPrenom(),
            ':date_naissance' => $joueur->getBirthdate()->format("Y-m-d"),
            ':photo' => $joueur->getImage(),
            ':role' => $joueur->getRole()->value
        ]);
    }

    /**
     * Récupère un joueur par son ID
     */
    public function findById(int $id): ?Joueur {
        $stmt = $this->pdo->prepare("SELECT * FROM joueurs WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new Joueur(
                $data['id'],
                $data['prenom'],
                $data['nom'],
                new DateTime($data['date_naissance']),
                Role::from($data['role']),
                $data['photo']
            );
        }

        return null;
    }

    /**
     * Retourne la liste de tous les joueurs
     */
    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM joueurs");
        $results = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = new Joueur(
                $data['id'],
                $data['prenom'],
                $data['nom'],
                new DateTime($data['date_naissance']),
                Role::from($data['role']),
                $data['photo']
            );
        }

        return $results;
    }

    /**
     * Supprime un joueur
     */
    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM joueurs WHERE id = ?");
        $stmt->execute([$id]);
    }
}

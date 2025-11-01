<?php
namespace App\Database;

use App\Model\Joueur;
use PDO;
use DateTime;

class JoueurDatabase {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function insert(Joueur $joueur): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO joueur (nom, prenom, date_de_naissance, photo)
            VALUES (:nom, :prenom, :date_de_naissance, :photo)
        ");

        $stmt->execute([
            ':nom' => $joueur->getNom(),
            ':prenom' => $joueur->getPrenom(),
            ':date_de_naissance' => $joueur->getBirthdate()->format("Y-m-d"),
            ':photo' => $joueur->getImage(),
        ]);
    }

    public function update(Joueur $joueur): void {
        $stmt = $this->pdo->prepare("
            UPDATE joueurs
            SET nom = :nom, prenom = :prenom, date_de_naissance = :date_de_naissance, photo = :photo
            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $joueur->getId(),
            ':nom' => $joueur->getNom(),
            ':prenom' => $joueur->getPrenom(),
            ':date_de_naissance' => $joueur->getBirthdate()->format("Y-m-d"),
            ':photo' => $joueur->getImage(),
        ]);
    }

    public function findById(int $id): ?Joueur {
        $stmt = $this->pdo->prepare("SELECT * FROM joueurs WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new Joueur(
                $data['id'],
                $data['prenom'],
                $data['nom'],
                new DateTime($data['date_de_naissance']),
                $data['photo']
            );
        }

        return null;
    }


    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM joueurs");
        $results = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = new Joueur(
                $data['id'],
                $data['prenom'],
                $data['nom'],
                new DateTime($data['date_de_naissance']),
                $data['photo']
            );
        }

        return $results;
    }

    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM joueurs WHERE id = ?");
        $stmt->execute([$id]);
    }
}

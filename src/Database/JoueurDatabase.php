<?php
namespace RedwaneValentin\Foot2Club\Database;

use RedwaneValentin\Foot2Club\Model\Joueur;
use RedwaneValentin\Foot2Club\Enum\Role;
use PDO;
use Carbon\Carbon;;

class JoueurDatabase {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    
    //Ajoute un joueur dans la base
    
    public function insert(Joueur $joueur): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO joueurs (nom, prenom, date_naissance, photo, role)
            VALUES (:nom, :prenom, :date_naissance, :photo, :role)
        ");

        $stmt->execute([
            ':nom' => $joueur->getNom(),
            ':prenom' => $joueur->getPrenom(),
            ':date_naissance' => $joueur->getDateNaissance()->format("Y-m-d"),
            ':photo' => $joueur->getImage(),
            ':role' => $joueur->getRole()->value
        ]);
    }

    
    //Met à jour un joueur existant
    
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
            ':date_naissance' => $joueur->getDateNaissance()->format("Y-m-d"),
            ':photo' => $joueur->getImage(),
            ':role' => $joueur->getRole()->value
        ]);
    }

    
    //Récupère un joueur par son ID
    
    public function findById(int $id): ?Joueur {
        $stmt = $this->pdo->prepare("SELECT * FROM joueurs WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $role = Role::tryFrom($data['role']) ?? Role::Gardien; 

            return new Joueur(
                $data['id'],
                $data['prenom'],
                $data['nom'],
                Carbon::parse($data['date_naissance']),
                $role,
                $data['photo']
            );
        }

        return null;
    }

    
    //Retourne la liste de tous les joueurs
    public function findAll(): array {
        
        // 1. Exécute la requête
        $stmt = $this->pdo->query("SELECT * FROM joueurs");
        
        // 2. Récupère TOUTES les données d'un coup dans un tableau
        $allData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        count($allData);
        echo "<pre>";
        var_dump($allData);
        echo "</pre>";
        die();
        $results = []; 
        foreach ($allData as $data) {
            
            $role = Role::tryFrom($data['role']) ?? Role::GARDIEN;

            $results[] = new Joueur(
                $data['id'],
                $data['prenom'],
                $data['nom'],
                Carbon::parse($data['date_naissance']),
                $role,
                $data['photo']
            );
        }

        return $results;
    }


      // Supprime un joueur
    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM joueurs WHERE id = ?");
        $stmt->execute([$id]);
    }
}
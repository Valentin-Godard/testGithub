<?php
namespace App\Database;

use App\Model\Staff;
use App\Enum\RoleStaff;
use PDO;

class StaffDatabase {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function insert(Staff $staff): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO staff (prenom, nom, image, role)
            VALUES (:prenom, :nom, :image, :role)
        ");
        return $stmt->execute([
            'prenom' => $staff->getPrenom(),
            'nom' => $staff->getNom(),
            'image' => $staff->getImage(),
            'role' => $staff->getRole()->value, // on enregistre la valeur de l’enum
        ]);
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM staff ORDER BY nom, prenom");
        $staffList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $staffList[] = new Staff(
                $row['prenom'],
                $row['nom'],
                $row['image'] ?? '',
                RoleStaff::from($row['role']) // on recrée l’enum à partir de la valeur
            );
        }
        return $staffList;
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM staff WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}

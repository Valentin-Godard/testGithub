<?php
namespace App\Database;

use App\Model\Staff;
use App\Enum\Role;
use PDO;
use DateTime;

<?php
namespace App\Database;

use App\Model\Staff;
use PDO;

class StaffDatabase {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Ajoute un membre du staff
     */
    public function insert(Staff $staff): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO staff (prenom, nom, image, role)
            VALUES (:prenom, :nom, :image, :role)
        ");
        return $stmt->execute([
            'prenom' => $staff->getPrenom(),
            'nom' => $staff->getNom(),
            'image' => $staff->getImage(),
            'role' => $staff->getRole(),
        ]);
    }

    /**
     * Récupère tout le staff
     * @return Staff[]
     */
    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM staff ORDER BY nom, prenom");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Staff(
                $row['prenom'],
                $row['nom'],
                $row['image'] ?? '',
                $row['role']
            );
        }
        return $result;
    }

    /**
     * Supprime un membre du staff
     */
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM staff WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}

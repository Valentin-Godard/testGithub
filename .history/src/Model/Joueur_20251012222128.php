<?php 

namespace App\Model;

use App\Contract\Savable;
use App\Trait\Image;
use DateTime;
use PDO;

class Joueur implements Savable {
    use Image;

    private ?int $id;
    private string $prenom;
    private string $nom;
    private DateTime $birthdate;

    public function __construct(?int $id, string $prenom, string $nom, DateTime $birthdate, ?string $image = null) {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->birthdate = $birthdate;
        $this->setImage($image);
    }

    /**
     * Sauvegarde le joueur (insert ou update)
     */
    public function save(PDO $pdo): void {
        if ($this->id === null) {
            $stmt = $pdo->prepare("
                INSERT INTO joueurs (nom, prenom, date_de_naissance, photo)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([
                $this->nom,
                $this->prenom,
                $this->birthdate->format("Y-m-d"),
                $this->getImage()
            ]);
            $this->id = (int)$pdo->lastInsertId();
        } else {
            $stmt = $pdo->prepare("
                UPDATE joueurs
                SET nom = ?, prenom = ?, date_de_naissance = ?, photo = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $this->nom,
                $this->prenom,
                $this->birthdate->format("Y-m-d"),
                $this->getImage(),
                $this->id
            ]);
        }
    }

    // Getters et Setters
    public function getPrenom(): string {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function getBirthdate(): DateTime {
        return $this->birthdate;
    }

    public function setBirthdate(DateTime $birthdate): void {
        $this->birthdate = $birthdate;
    }

    public function getImage(): string {
        return $this->image;
    }

    public function setImage(?string $image): void {
        $this->image = $image ?? 'default.jpg';
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }
}

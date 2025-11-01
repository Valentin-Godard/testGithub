<?php 

namespace App\Model;

use App\Contract\Savable;
use App\Trait\Image;
use App\Enum\Role;
use DateTime;
use PDO;

class Joueur implements Savable {
    use Image;

    private ?int $id;
    private string $prenom;
    private string $nom;
    private DateTime $birthdate;
    private Role $role;

    public function __construct(?int $id, string $prenom, string $nom, DateTime $birthdate, string $image) {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->birthdate = $birthdate;
        $this->setImage($image);
    }

    //suivre : https://www.php.net/manual/fr/pdostatement.execute.php
    public function save(PDO $pdo): void {
        if ($this->id === null) {
            $stmt = $pdo->prepare("INSERT INTO joueurs (nom, prenom, date_naissance, photo, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$this->nom, $this->prenom, $this->birthdate->format("Y-m-d"), $this->getImage(), $this->role->value]);
            $this->id = $pdo->lastInsertId();
        } else {
            $stmt = $pdo->prepare("UPDATE joueurs SET nom=?, prenom=?, date_naissance=?, photo=?, role=? WHERE id=?");
            $stmt->execute([$this->nom, $this->prenom, $this->birthdate->format("Y-m-d"), $this->getImage(), $this->role->value, $this->id]);
        }
    }

    // Getter et Setter pour prénom
    public function getPrenom(): string {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }

    // Getter et Setter pour nom
    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    // Getter et Setter pour birthdate
    public function getBirthdate(): DateTime {
        return $this->birthdate;
    }

    public function setBirthdate(DateTime $birthdate): void {
        $this->birthdate = $birthdate;
    }

    public function getImage(): string {
        return $this->image;
    }

    public function setImage(string $image): void {
        $this->image = $image;
    }

    public function getRole(): Role {
        return $this->role;
    }

    public function setRole(Role $role): void {
        $this->role = $role;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

}

/*
$j1 = new Joueur("Kylian", "Mbappé", new DateTime("1998-12-20"), "mbappe.jpg");
$j2 = new Joueur("Antoine", "Griezmann", new DateTime("1991-03-21"), "griezmann.jpg");
$j3 = new Joueur("Ousmane", "Dembélé", new DateTime("1997-05-15"), "dembele.jpg");
*/

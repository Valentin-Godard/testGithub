
<?php
namespace App\Model;

use App\Enum\RoleStaff;

class Staff {
    private string $prenom;
    private string $nom;
    private string $image;
    private RoleStaff $role;

    public function __construct(string $prenom, string $nom, string $image, RoleStaff $role) {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->image = $image;
        $this->role = $role;
    }

    public function getPrenom(): string { return $this->prenom; }
    public function setPrenom(string $prenom): void { $this->prenom = $prenom; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }

    public function getImage(): string { return $this->image; }
    public function setImage(string $image): void { $this->image = $image; }

    public function getRole(): RoleStaff { return $this->role; }
    public function setRole(RoleStaff $role): void { $this->role = $role; }
}



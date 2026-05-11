
<?php 

class joueur{
    private string $prenom;
    private string $nom;
    private Carbon $birthdate;
    private string $image;
    
    public function __construct(string  $prenom, string $nom, DateTime $birthdate, string $image  ) {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->birthdate = $birthdate;
        $this->image= $image;
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
    public function getBirthdate(): Carbon { 
    return $this->birthdate;
}

public function setBirthdate(Carbon $birthdate): void { 
    $this->birthdate = $birthdate;
}

    public function getImage(): string {
        return $this->image;
    }

    public function setImage(string $image): void {
        $this->image = $image;
    }
}


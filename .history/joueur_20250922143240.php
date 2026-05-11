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

    public function getPrenom(){
        return $this->prenom ;
    }

    public function setPrenom($prenom) :void{
        $this->prenom = $prenom ;
    }

}
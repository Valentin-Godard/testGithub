<?php 

class joueurDansEquipe{

    private string $role;

    public function __construct(string $role) {
        $this->role = $role;
    }

    public function getRole(): string {
        return $this->role;
    }

    // Setter pour role
    public function setRole(string $role): void {
        $this->role = $role;
    }


}
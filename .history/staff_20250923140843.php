<?php

class staff{
    public string $prenom;
    public string $nom;
    public string $anniversaire;
    public string $image;

    public function __construct(Type $var = null) {
        $this->var = $var;
    }
}
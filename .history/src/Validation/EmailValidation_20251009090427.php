<?php
namespace RedwaneValentin\Foot2Club\Validation;

class EmailValidation implements ValidatorInterface {
    private ?string $errorMessage = null;

    /**
     * Vérifie qu’un email est valide (syntaxe simple + non vide)
     */
    public function isValid(mixed $value): bool {
        // Vérifie si vide
        if (empty($value)) {
            $this->errorMessage = "L’adresse email ne peut pas être vide.";
            return false;
        }

        // Vérifie format email
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errorMessage = "Format d’adresse email invalide.";
            return false;
        }

        // Tout est bon
        $this->errorMessage = null;
        return true;
    }

    public function getErrorMessage(): ?string {
        return $this->errorMessage;
    }
}

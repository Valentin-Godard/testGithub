<?php 
require_once __DIR__ . '/vendor/autoload.php';

// On importe les classes de validation
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "footclub";

try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (isset($_POST['ok'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_clair = $_POST['mdp'];

    // 1. Définir les règles de validation
    $usernameValidator = v::stringType()->notEmpty()->length(3, 50)->setName('Nom d\'utilisateur');
    $emailValidator = v::email()->setName('Email');
    $passwordValidator = v::stringType()->notEmpty()->length(8, null)->setName('Mot de passe'); // 8 caractères min

    try {
        // 2. Valider les données
        $usernameValidator->assert($username);
        $emailValidator->assert($email);
        $passwordValidator->assert($password_clair);

        // 3. Si tout est valide, on continue
        $password_hash = password_hash($password_clair, PASSWORD_DEFAULT);

        $requete = $bdd->prepare("INSERT INTO users (username, email, mdp) 
                                  VALUES (:username, :email, :mdp)");
        $success = $requete->execute([
            'username' => $username,
            'email' => $email,
            'mdp' => $password_hash
        ]);

        if ($success) {
            echo "Inscription réussie !";
            ?> <a href="connexion.php">Cliquez ici pour vous connecter !</a> <?php
        } else {
            echo "Erreur lors de l'inscription.";
        }

    } catch (NestedValidationException $e) {
        // 4. Si la validation échoue, on affiche les erreurs
        echo "<h3>Erreur de validation :</h3><ul>";
        // getMessages() retourne les messages d'erreur personnalisés
        foreach ($e->getMessages() as $message) {
            echo "<li>$message</li>";
        }
        echo "</ul>";
        echo '<a href="inscription.php">Retour au formulaire</a>';
    }
} else {
    echo "Veuillez remplir le formulaire d'inscription.";
}
?>
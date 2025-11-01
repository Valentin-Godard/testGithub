<?php

require_once __DIR__ . '/../autol';
require_once __DIR__ . '/../includes/database.php';

use App\Model\Joueur;
use App\Enum\Role;
use App\Database\JoueurDatabase;

$joueurDb = new JoueurDatabase($pdo);

$message = "";

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $prenom = trim($_POST["prenom"]);
    $nom = trim($_POST["nom"]);
    $dateNaissance = new DateTime($_POST["date_naissance"]);
    $roleValue = $_POST["role"] ?? null;

    // Validation du rôle
    try {
        $role = Role::from($roleValue);
    } catch (ValueError $e) {
        $message = "❌ Rôle invalide.";
    }

    // Gestion de la photo
    $photoName = "";
    if (!empty($_FILES["photo"]["name"])) {
        $uploadDir = __DIR__ . "/../public/uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $photoName = basename($_FILES["photo"]["name"]);
        $targetPath = $uploadDir . $photoName;

        if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $targetPath)) {
            $message = "❌ Erreur lors de l’upload de la photo.";
        }
    }

    // Si tout est valide
    if (empty($message)) {
        $joueur = new Joueur(
            null,
            $prenom,
            $nom,
            $dateNaissance,
            $role,
            $photoName
        );

        // ➕ Ajout du joueur via JoueurDatabase
        $joueurDb->insert($joueur);

        $message = "✅ Joueur ajouté avec succès !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un joueur</title>
    <style>
        body { font-family: Arial; margin: 30px; background-color: #f7f7f7; }
        form { background: white; padding: 20px; border-radius: 10px; width: 400px; }
        label { font-weight: bold; display: block; margin-top: 10px; }
        input, select, button { width: 100%; padding: 8px; margin-top: 5px; }
        button { background-color: #4CAF50; color: white; border: none; cursor: pointer; margin-top: 15px; }
        button:hover { background-color: #45a049; }
        .message { margin-top: 15px; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Ajouter un joueur</h1>

    <?php if (!empty($message)): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Prénom :</label>
        <input type="text" name="prenom" required>

        <label>Nom :</label>
        <input type="text" name="nom" required>

        <label>Date de naissance :</label>
        <input type="date" name="date_naissance" required>

        <label>Rôle :</label>
        <select name="role" required>
            <option value="">-- Sélectionner un rôle --</option>
            <?php foreach (Role::cases() as $case): ?>
                <option value="<?= $case->value ?>"><?= $case->value ?></option>
            <?php endforeach; ?>
        </select>

        <label>Photo :</label>
        <input type="file" name="photo" accept="image/*" required>

        <button type="submit">Ajouter le joueur</button>
    </form>
</body>
</html>

<?php
require_once "joueur.php";
require_once "includes/database.php";
require_once "includes/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $dateNaissance = new DateTime($_POST["date_naissance"]);
    $photo = $_FILES["photo"]["name"]; // on récupère juste le nom du fichier pour l’instant

    // Création de l’objet joueur
    $joueur = new Joueur($nom, $prenom, $dateNaissance, $photo);

    $stmt = $pdo->prepare("INSERT INTO joueurs (nom, prenom, date_naissance, photo) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $joueur->getNom(),
        $joueur->getPrenom(),
        $joueur->getBirthdate()->format("Y-m-d"),
        $joueur->getImage()
    ]);

    echo "<pre>";
    var_dump($joueur);
    echo "</pre>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un joueur</title>
</head>
<body>
    <h1>Ajouter un joueur</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Nom :</label>
        <input type="text" name="nom" required><br><br>

        <label>Prénom :</label>
        <input type="text" name="prenom" required><br><br>

        <label>Date de naissance :</label>
        <input type="date" name="date_naissance" required><br><br>

        <label>Photo :</label>
        <input type="file" name="photo" accept="image/*" required><br><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
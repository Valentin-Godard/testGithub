<?php
require_once __DIR__ . '/../src/autoload.php';
require_once __DIR__ . '/../includes/database.php';

use App\Model\Joueur;
use App\Model\MatchFoot;
use App\Model\Equipe;
use App\Enum\Role;
use App\Database\JoueurDatabase;
use App\Database\MatchDatabase;
use App\Database\EquipeDatabase;

// Instanciation des Database
$joueurDb = new JoueurDatabase($pdo);
$matchDb = new MatchDatabase($pdo);
$equipeDb = new EquipeDatabase($pdo);

// Récupération des équipes pour listes déroulantes
$equipes = $equipeDb->findAll();

$message = "";

// ---------------------- AJOUT D'ÉQUIPE ----------------------
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['form_type'] ?? '') === 'equipe') {
    $nomEquipe = trim($_POST["nom_equipe"]);
    if ($nomEquipe !== "") {
        $equipe = new Equipe(null, $nomEquipe);
        $equipeDb->insert($equipe);
        $message = "✅ Équipe ajoutée avec succès !";
        $equipes = $equipeDb->findAll(); // rafraîchir la liste
    } else {
        $message = "❌ Nom d'équipe vide.";
    }
}

// ---------------------- AJOUT DE JOUEUR ----------------------
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['form_type'] ?? '') === 'joueur') {
    $prenom = trim($_POST["prenom"]);
    $nom = trim($_POST["nom"]);
    $dateNaissance = new DateTime($_POST["date_naissance"]);
    $roleValue = $_POST["role"] ?? null;

    // Validation du rôle
    $role = null;
    try {
        $role = Role::from($roleValue);
    } catch (ValueError $e) {
        $message = "❌ Rôle invalide.";
    }

    // Gestion de la photo
    $photoName = "";
    if (!empty($_FILES["photo"]["name"])) {
        $uploadDir = __DIR__ . "/public/uploads/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $photoName = basename($_FILES["photo"]["name"]);
        $targetPath = $uploadDir . $photoName;
        if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $targetPath)) {
            $message = "❌ Erreur lors de l’upload de la photo.";
        }
    }

    // Insertion dans la base si tout est valide
    if (empty($message) && $role !== null) {
        $joueur = new Joueur(null, $prenom, $nom, $dateNaissance, $role, $photoName);
        $joueurDb->insert($joueur);
        $message = "✅ Joueur ajouté avec succès !";
    }
}

// ---------------------- AJOUT DE MATCH ----------------------
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['form_type'] ?? '') === 'match') {
    $scoreEquipe = $_POST["score_equipe"];
    $scoreAdverse = $_POST["score_adverse"];
    $dateMatch = new DateTime($_POST["date_match"]);
    $ville = trim($_POST["ville"]);
    $equipeId = (int)$_POST["equipe_id"];
    $adversaireId = (int)$_POST["club_adverse_id"];

    $match = new MatchFoot(null, $scoreEquipe, $scoreAdverse, $dateMatch, $ville, $equipeId, $adversaireId);
    $matchDb->insert($match);

    $message = "✅ Match ajouté avec succès !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion FootDeClub</title>
    <style>
        body { font-family: Arial; margin: 30px; background-color: #f7f7f7; }
        form { background: white; padding: 20px; border-radius: 10px; width: 400px; margin-bottom: 20px; }
        label { font-weight: bold; display: block; margin-top: 10px; }
        input, select, button { width: 100%; padding: 8px; margin-top: 5px; }
        button { background-color: #4CAF50; color: white; border: none; cursor: pointer; margin-top: 15px; }
        button:hover { background-color: #45a049; }
        .message { margin-top: 15px; font-weight: bold; }
    </style>
</head>
<body>

<h1>Ajouter une équipe</h1>
<form method="POST">
    <input type="hidden" name="form_type" value="equipe">
    <label>Nom de l'équipe :</label>
    <input type="text" name="nom_equipe" required>
    <button type="submit">Ajouter l'équipe</button>
</form>

<h1>Ajouter un joueur</h1>
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="form_type" value="joueur">
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

<h1>Ajouter un match</h1>
<form method="POST">
    <input type="hidden" name="form_type" value="match">
    <label>Score équipe :</label>
    <input type="text" name="score_equipe" required>
    <label>Score adverse :</label>
    <input type="text" name="score_adverse" required>
    <label>Date du match :</label>
    <input type="date" name="date_match" required>
    <label>Ville :</label>
    <input type="text" name="ville" required>
    <label>Équipe :</label>
    <select name="equipe_id" required>
        <?php foreach ($equipes as $equipe): ?>
            <option value="<?= $equipe->getId() ?>"><?= htmlspecialchars($equipe->getNom()) ?></option>
        <?php endforeach; ?>
    </select>
    <label>Club adverse :</label>
    <select name="club_adverse_id" required>
        <?php foreach ($equipes as $equipe): ?>
            <option value="<?= $equipe->getId() ?>"><?= htmlspecialchars($equipe->getNom()) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Ajouter le match</button>
</form>

<?php if (!empty($message)): ?>
    <p class="message"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

</body>
</html>

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
use App\Database\JoueurEquipeDatabase;

// Instanciation des Database
$joueurDb = new JoueurDatabase($pdo);
$matchDb = new MatchDatabase($pdo);
$equipeDb = new EquipeDatabase($pdo);
$joueurEquipeDb = new JoueurEquipeDatabase($pdo);

// Récupération des équipes pour listes déroulantes
// Récupération des équipes et clubs adverses
$teamsStmt = $pdo->query("SELECT id, nom FROM equipe");
$teams = $teamsStmt->fetchAll(PDO::FETCH_ASSOC);

$clubsStmt = $pdo->query("SELECT id, ville FROM club_adverse");
$clubs = $clubsStmt->fetchAll(PDO::FETCH_ASSOC);

$message = "";

// ---------------------- AJOUT D'ÉQUIPE ----------------------

if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['form_type'] ?? '') === 'equipe') {
    $nomEquipe = trim($_POST["nom"]);
    $ville = trim($_POST["ville"]);
    $adresse = trim($_POST["adresse"]);

    if ($nomEquipe !== "" && $ville !== "" && $adresse !== "") {
        $equipe = new Equipe(null, $nomEquipe, '', ''); // nom seulement pour équipes
        $equipeDb = new EquipeDatabase($pdo);

        $success = $equipeDb->addEquipeWithClubAdverseDirect($equipe, $ville, $adresse);

        if ($success) {
            $message = "✅ Équipe ajoutée avec succès !";
        } else {
            $message = "❌ Erreur lors de l'ajout de l'équipe.";
        }
    } else {
        $message = "❌ Veuillez remplir tous les champs.";
    }
}



// ---------------------- AJOUT DE JOUEUR ----------------------
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['form_type'] ?? '') === 'joueur') {
    $prenom = trim($_POST["prenom"]);
    $nom = trim($_POST["nom"]);
    $dateNaissance = new DateTime($_POST["date_naissance"]);
    $equipeId = (int)$_POST["equipe_id"];
    $roleValue = $_POST["role"];

    // Gestion de la photo
    $photoName = "";
    if (!empty($_FILES["photo"]["name"])) {
        $uploadDir = __DIR__ . "/uploads/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $photoName = basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $uploadDir . $photoName);
    }

    // 1️⃣ Ajouter le joueur
    $joueur = new Joueur(null, $prenom, $nom, $dateNaissance, null, $photoName);
    $joueurDb->insert($joueur);
    $joueurId = $pdo->lastInsertId();

    // 2️⃣ Ajouter la relation joueur ↔ équipe avec rôle
    $joueurEquipeDb->insert($joueurId, $equipeId, $roleValue);

    $message = "✅ Joueur ajouté avec succès dans l'équipe !";
}

// ---------------------- AJOUT DE MATCH ----------------------
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['form_type'] ?? '') === 'match') {
    $teamScore = (int)$_POST['team_score'];
    $opponentScore = (int)$_POST['opponent_score'];
    $dateMatch = new DateTime($_POST['date_match']);
    $city = trim($_POST['city']);
    $teamId = (int)$_POST['team_id'];
    $clubAdvId = (int)$_POST['club_adv_id'];

    $match = new MatchFoot(
        null,
        $teamScore,
        $opponentScore,
        $dateMatch,
        $teamId,
        $city,
        $clubAdvId
    );

    $matchDb = new MatchDatabase($pdo);
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
    <input type="text" name="nom" required>

    <label>Ville :</label>
    <input type="text" name="ville" required>

    <label>Adresse :</label>
    <input type="text" name="adresse" required>

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

    <label>Équipe :</label>
    <select name="equipe_id" required>
        <option value="">-- Sélectionner une équipe --</option>
        <?php foreach ($equipes as $equipe): ?>
            <option value="<?= $equipe->getId() ?>"><?= htmlspecialchars($equipe->getNom()) ?></option>
        <?php endforeach; ?>
    </select>

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

<<h1>Ajouter un match</h1>

<form method="POST">
    <input type="hidden" name="form_type" value="match">

    <label>Score équipe :</label>
    <input type="number" name="team_score" required>

    <label>Score adverse :</label>
    <input type="number" name="opponent_score" required>

    <label>Date du match :</label>
    <input type="date" name="date_match" required>

    <label>Ville :</label>
    <input type="text" name="city" required>

    <label>Équipe :</label>
    <select name="team_id" required>
        <?php foreach ($teams as $team): ?>
            <option value="<?= (int)$team['id'] ?>">
                <?= htmlspecialchars($team['nom']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Club adverse :</label>
    <select name="club_adv_id" required>
        <?php foreach ($clubs as $club): ?>
            <option value="<?= (int)$club['id'] ?>">
                <?= htmlspecialchars($club['ville']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Ajouter le match</button>
</form>


<?php if (!empty($message)): ?>
    <p class="message"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>


<h2>Liste des joueurs</h2>

<?php
// Récupérer tous les joueurs
$stmt = $pdo->query("SELECT j.id, j.nom, j.prenom, e.nom AS equipe
                     FROM joueur j
                     LEFT JOIN equipe e ON j.id = e.id"); 
$joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Équipe</th>
    </tr>
    <?php foreach ($joueurs as $joueur): ?>
        <tr>
            <td><?= $joueur['id'] ?></td>
            <td><?= htmlspecialchars($joueur['nom']) ?></td>
            <td><?= htmlspecialchars($joueur['prenom']) ?></td>
            <td><?= htmlspecialchars($joueur['equipe']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<h2>Résultats des matchs</h2>

<?php
// Récupérer les matchs avec équipes
$stmt = $pdo->query("
    SELECT m.id, t1.nom AS equipe, t2.nom AS adversaire, m.team_score, m.opponent_score, m.date_match, m.city
    FROM matches m
    LEFT JOIN equipes t1 ON m.team_id = t1.id
    LEFT JOIN equipes t2 ON m.opponent_team_id = t2.id
    ORDER BY m.date_match DESC
");
$matchs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Équipe</th>
        <th>Adversaire</th>
        <th>Score</th>
        <th>Date</th>
        <th>Ville</th>
    </tr>
    <?php foreach ($matchs as $match): ?>
        <tr>
            <td><?= $match['id'] ?></td>
            <td><?= htmlspecialchars($match['equipe']) ?></td>
            <td><?= htmlspecialchars($match['adversaire']) ?></td>
            <td><?= $match['team_score'] ?> - <?= $match['opponent_score'] ?></td>
            <td><?= htmlspecialchars($match['date_match']) ?></td>
            <td><?= htmlspecialchars($match['city']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>


</body>
</html>

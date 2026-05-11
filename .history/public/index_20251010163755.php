<?php
require_once __DIR__ . '/../src/autoload.php';
require_once __DIR__ . '/../includes/database.php';

use App\Database\MatchDatabase;
use App\Database\EquipeDatabase;
use App\Model\MatchFoot;

$matchDb = new MatchDatabase($pdo);
$equipeDb = new EquipeDatabase($pdo);
$equipes = $equipeDb->findAll();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'match') {
    $scoreEquipe = $_POST['score_equipe'];
    $scoreAdverse = $_POST['score_adverse'];
    $dateMatch = new DateTime($_POST['date_match']);
    $ville = $_POST['ville'];
    $equipeId = (int)$_POST['equipe_id'];
    $adversaireId = (int)$_POST['club_adverse_id'];

    $match = new MatchFoot(null, $scoreEquipe, $scoreAdverse, $dateMatch, $ville, $equipeId, $adversaireId);
    $matchDb->insert($match);

    $message = "✅ Match ajouté avec succès !";
}
?>

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

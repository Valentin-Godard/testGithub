<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/database.php';

use RedwaneValentin\Foot2Club\Model\Joueur;
use RedwaneValentin\Foot2Club\Enum\Role;
use RedwaneValentin\Foot2Club\Database\JoueurDatabase;
use Carbon\Carbon; 
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

$pdo_instance = App\Database::getInstance()->getConnection();
$joueurDb = new JoueurDatabase($pdo_instance);
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $prenom = trim($_POST["prenom"]);
    $nom = trim($_POST["nom"]);
    $dateNaissanceInput = $_POST["date_naissance"];
    $roleValue = $_POST["role"] ?? null;

    // Définir les règles de validation
    $stringValidator = v::stringType()->notEmpty()->length(2, 255);
    $dateValidator = v::date('Y-m-d')->notEmpty()->max(Carbon::now()->format('Y-m-d')); // Date doit être dans le passé
    $roleValidator = v::in(array_column(Role::cases(), 'value')); 

    try {
        // Valider les données
        $stringValidator->assert($prenom);
        $stringValidator->assert($nom);
        $dateValidator->assert($dateNaissanceInput);
        $roleValidator->assert($roleValue);

        $dateNaissance = Carbon::parse($dateNaissanceInput); // On crée l'objet Carbon
        $role = Role::from($roleValue);

        $photoName = "";
        if (!empty($_FILES["photo"]["name"])) {
            $uploadDir = __DIR__ . "/uploads/"; // Simplifié
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $photoName = basename($_FILES["photo"]["name"]);
            if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $uploadDir . $photoName))
                $message = "❌ Erreur lors de l’upload de la photo.";
        }

        if (empty($message)) { 
            $joueur = new Joueur(null, $prenom, $nom, $dateNaissance, $role, $photoName);
            $joueurDb->insert($joueur);
            $message = "✅ Joueur ajouté avec succès !";
        }

    } catch(NestedValidationException $e) {
        // En cas d'erreur de validation
        $message = "❌ Erreurs de validation : <br>" . implode('<br>', $e->getMessages());
    } catch (ValueError $e) { 
        // En cas de rôle invalide (ne devrait plus arriver grâce à la validation)
        $message = "❌ Rôle invalide."; 
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter un joueur — FC Aurora</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="page-root">
  <header class="site-header fade-in">
    <div class="brand">
      <div class="logo">⚽</div>
      <h1>FC Aurora</h1>
    </div>
    <div class="user-area">
      <span>Connecté en tant que : <strong><?php echo $_COOKIE['username'] ?? 'Invité'; ?></strong></span>
      <a class="btn-logout" href="deconnexion.php">Se déconnecter</a>
    </div>
  </header>

  <main class="container fade-in">
    <section class="form-section card">
      <h2>Ajouter un joueur</h2>
      <?php if (!empty($message)) echo "<div class='message-box'>$message</div>"; ?>
      <form method="POST" enctype="multipart/form-data" class="styled-form" novalidate>
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
            <option value="<?= htmlspecialchars($case->value) ?>"><?= htmlspecialchars($case->value) ?></option>
          <?php endforeach; ?>
        </select>

        <label>Photo :</label>
        <input type="file" name="photo" accept="image/*" required>

        <button type="submit" class="btn">Ajouter le joueur</button>
      </form>
      <button> <a href="listeJoueurs.php" class="btn-secondary">Retour à la liste des joueurs</a></button>
    </section>
  </main>

  <footer class="site-footer fade-in">
    <small>© <span id="year"></span> FC Aurora — Gestion du club</small>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.getElementById('year').textContent = new Date().getFullYear();
      document.querySelectorAll('.fade-in').forEach((el, i)=>{
        el.style.transition = 'all 450ms ease';
        el.style.transitionDelay = (i*100)+'ms';
        el.style.opacity = '1';
        el.style.transform = 'translateY(0)';
      });
    });
  </script>
  <script>
document.getElementById('file-upload').onchange = function () {
    var fileName = this.files[0] ? this.files[0].name : "Aucun fichier sélectionné";
    var span = this.previousElementSibling.querySelector('.player-form-file-name');
    span.textContent = fileName;
};
</script>
</body>
</html>

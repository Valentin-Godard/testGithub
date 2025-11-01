<?php
//require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../includes/database.php';

use RedwaneValentin\Foot2Club\Model\Joueur;
use RedwaneValentin\Foot2Club\Enum\Role;
use RedwaneValentin\Foot2Club\Database\JoueurDatabase;

//$joueurDb = new JoueurDatabase($pdo);
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $prenom = trim($_POST["prenom"]);
    $nom = trim($_POST["nom"]);
    $dateNaissance = new DateTime($_POST["date_naissance"]);
    $roleValue = $_POST["role"] ?? null;

    try { $role = Role::from($roleValue); } 
    catch (ValueError $e) { $message = "❌ Rôle invalide."; }

    $photoName = "";
    if (!empty($_FILES["photo"]["name"])) {
        $uploadDir = __DIR__ . "/../public/uploads/";
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
</body>
</html>

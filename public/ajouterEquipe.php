<?php
// 1. Chargement
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/database.php';

use RedwaneValentin\Foot2Club\Model\Equipe;
use RedwaneValentin\Foot2Club\Database\EquipeDatabase;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

$message = "";
$message_class = "";

// 2. Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nomEquipe = trim($_POST["nom"]);

    try {
        // 3. Validation
        v::stringType()->notEmpty()->length(2, 100)->setName('Nom de l\'équipe')->assert($nomEquipe);

        // 4. Création et insertion
        $equipe = new Equipe($nomEquipe);
        $equipeDb = new EquipeDatabase($connection); // $connection vient de database.php
        $equipeDb->insert($equipe);

        $message = "✅ Équipe ajoutée avec succès !";
        $message_class = "success";

    } catch(NestedValidationException $e) {
        $message = "❌ Erreurs de validation : <br>" . implode('<br>', $e->getMessages());
        $message_class = "error";
    } catch (Exception $e) {
        $message = "❌ Une erreur est survenue : " . $e->getMessage();
        $message_class = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter une Équipe — FC Aurora</title>
  <link rel="stylesheet" href="../style.css"> </head>
<body class="page-root">
  <header class="site-header fade-in">
    </header>

  <main class="container fade-in">
    <section class="form-container_AEQ">
      <h2 class="form-title_AEQ">Ajouter une nouvelle équipe</h2>
      
      <?php if (!empty($message)): ?>
          <div class="message-box <?= $message_class ?>"><?= $message ?></div>
      <?php endif; ?>
      
      <form method="POST" class="form_AEQ" novalidate>
        
        <label class="form-label_AEQ" for="nom_AEQ">Nom de l'équipe :</label>
        <input class="form-input_AEQ" type="text" id="nom_AEQ" name="nom" required>

        <button type="submit" class="form-submit_AEQ">Ajouter l'équipe</button>
        <a href="listeEquipes.php" class="form-back-link_AEQ">Retour à la liste des équipes</a>
      </form>
    </section>
  </main>

  <footer class="site-footer fade-in">
    <small>© <span id="year"></span> FC Aurora — Gestion du club</small>
  </footer>
  
  <script>
    // (JS pour fade-in et date)
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
<?php
// 1. Chargement
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/database.php';

use RedwaneValentin\Foot2Club\Database\EquipeDatabase;

$equipeDb = new EquipeDatabase($connection);
$equipes = $equipeDb->findAll();

$message = "";
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'deleted') {
        $message = "✅ Équipe supprimée avec succès !";
        $message_class = "success";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Équipes — FC Aurora</title>
    <link rel="stylesheet" href="../style.css"> </head>
<body class="page-root">
    <header class="site-header fade-in">
      </header>

    <main class="container fade-in">
        <section class="table-container_LEQ">
            <h2 class="table-title_LEQ">Gestion des Équipes</h2>
            
            <?php if (!empty($message)): ?>
                <div class="message-box <?= $message_class ?>"><?= $message ?></div>
            <?php endif; ?>

            <a href="ajouterEquipe.php" class="add-button_LEQ">Ajouter une nouvelle équipe</a>
            
            <table class="styled-table_LEQ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($equipes)): ?>
                        <tr>
                            <td colspan="3" style="text-align: center;">Aucune équipe trouvée.</td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($equipes as $equipe): ?>
                        <tr>
                            <td><?= $equipe->getId() ?></td>
                            <td><?= htmlspecialchars($equipe->getNom()) ?></td>
                            <td class="action-links_LEQ">
                                <a href="modifierEquipe.php?id=<?= $equipe->getId() ?>" class="edit_LEQ">Modifier</a>
                                <a href="supprimerEquipe.php?id=<?= $equipe->getId() ?>" class="delete_LEQ" onclick="return confirm('Êtes-vous sûr ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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
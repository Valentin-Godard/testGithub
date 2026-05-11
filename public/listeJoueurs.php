<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/database.php';

use RedwaneValentin\Foot2Club\Database\JoueurDatabase;

$joueurDb = new JoueurDatabase($connection);
$joueurs = $joueurDb->findAll();

// Gestion des messages de succès (après suppression/modification)
$message = "";
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'deleted') {
        $message = "✅ Joueur supprimé avec succès !";
    }
    if ($_GET['status'] === 'updated') {
        $message = "✅ Joueur mis à jour avec succès !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Joueurs — FC Aurora</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-root">
    <header class="site-header fade-in">
        <div class="brand">
            <div class="logo">⚽</div>
            <h1>FC Aurora</h1>
        </div>
        </header>

    <main class="container fade-in">
        <section class="table-container_LJR">
            <h2 class="table-title_LJR">Gestion des Joueurs</h2>
            
            <?php if (!empty($message)): ?>
                <div class="message-box success"><?= $message ?></div>
            <?php endif; ?>

            <a href="ajouterUnJoueur.php" class="add-button_LJR">Ajouter un nouveau joueur</a>
            
            <table class="styled-table_LJR">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Âge </th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($joueurs)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">Aucun joueur trouvé.</td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($joueurs as $joueur): ?>
                        <tr>
                            <td><?= htmlspecialchars($joueur->getNom()) ?></td>
                            <td><?= htmlspecialchars($joueur->getPrenom()) ?></td>
                            <td><?= $joueur->getAge() ?> ans</td> <td><?= htmlspecialchars($joueur->getRole()->value) ?></td>
                            <td class="action-links_LJR">
                                <a href="modifierJoueur.php?id=<?= $joueur->getId() ?>" class="edit_LJR">Modifier</a>
                                <a href="supprimerJoueur.php?id=<?= $joueur->getId() ?>" class="delete_LJR" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce joueur ?');">Supprimer</a>
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
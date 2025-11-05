<?php
require_once __DIR__ . '/../vendor/autoload.php';

 $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "footclub";

      try {
          $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
      } catch(PDOException $e) {
          echo "<p class='message-box'>Connection failed: " . $e->getMessage() . "</p>";
      }

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $email = $_POST['email'] ?? '';
          $password = $_POST['password'] ?? '';
          $username = $_POST['username'] ?? '';
          if ($email && $password && $username) {
              $req = $bdd->query("SELECT * FROM users WHERE email = '$email' AND mdp = '$password' AND username = '$username'");
              $rep = $req->fetch();
              if ($rep) {
                  setcookie("email", $email, time() + 3600);
                  setcookie("mdp", $password, time() + 3600);
                  setcookie("username", $username, time() + 3600);
                  header("Location: index.php");
              } else {
                  $error_msg = "Email ou mot de passe incorrect.";
              }
          }
      }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion — FC Aurora</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="page-root">
  <main class="container fade-in">
    <section class="card form-section">
      <h2>Connexion</h2>

      <form method="POST" action="" class="styled-form" novalidate>
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Adresse e-mail :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="btn">Se connecter</button>
        <a href="inscription.php" class="btn ghost">S'inscrire</a>
      </form>

      <?php if(isset($error_msg)) echo "<p class='message-box'>$error_msg</p>"; ?>
    </section>
  </main>
</body>
</html>

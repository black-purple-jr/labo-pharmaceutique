<?php
session_start();
$error_message = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["email"]) && isset($_POST["passwd"])) {
    $email = $_POST["email"];
    if ($_POST["passwd"] !== "") {
      $passwd = $_POST["passwd"];
    } else {
      $error_message = "Mot de passe vide";
    }
    require "../DAO.php";
    $result = null;

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      // la fonction filter_var sert à verfier l'email sans tester avec une expression régulière.
      $result = DAO::get_user($email);
      if ($result) {
        $error_message = "Un compte existe déjà avec cet email.";
      }
      if (!$result) {
        try {
          $hash = password_hash($passwd, PASSWORD_DEFAULT);
          $created = DAO::create_user($email, $hash);
          if ($created) {
            header("Location: login.php");
            exit;
          } else {
            $error_message = "La création du compte a échoué. Veuillez réessayer.";
          }
        } catch (Exception $e) {
          $error_message = "Erreur: " . $e->getMessage();
        }
      }
    } else {
      $error_message = "Veuillez remplir tous les champs.";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Styles/auth.css">
  <title>Créer Votre Compte - Labo Pharmaceutique</title>
  <link rel="icon" type="image/svg+xml" href="../Assets/icon.svg">
</head>

<body>
  <?php if ($error_message): ?>
    <p class="error"><?php echo htmlspecialchars($error_message) ?></p>
  <?php endif; ?>
  <form action="" method="post">
    <h2>Créer un compte</h2>

    <label for="email-input">Email</label>
    <input type="email" id="email-input" name="email" />

    <label for="pwd-input">Mot de passe</label>
    <input type="password" id="pwd-input" name="passwd" />

    <button type="submit">
      Créer votre compte
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save-check-icon lucide-save-check">
        <path d="M12.5 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h10.2a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4v4.35" />
        <path d="m16 19 2 2 4-4" />
        <path d="M17 15.13V14a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
        <path d="M7 3v4a1 1 0 0 0 1 1h7" />
      </svg>
    </button>
    <a href="login.php">Se connecter à un compte existant.</a>
  </form>
</body>

</html>
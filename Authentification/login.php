<?php
session_start();
$error_message = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["email"]) && isset($_POST["passwd"])) {
    $email = $_POST["email"];
    $passwd = $_POST["passwd"];
    require "../DAO.php";
    $result = null;

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      // la fonction filter_var sert à verfier l'email sans tester avec une expression régulière.
      $result = DAO::get_user($email);

      if ($result && password_verify($passwd, $result["password_hash"])) {
        $_SESSION["user_id"] = $result["id"];
        // header("Location: ../index.php"); route = localhost/fil_rouge/index.php
        header("Location: ../"); // cette méthode vas automatiquement a le fichhier index; route = localhost/fil_rouge/ ; donc cette deuxième méthode nous donne un route plus propre.
        exit;
      } else {
        $error_message = "Email ou mot de passe incorrect.";
      }
    } else {
      $error_message = "Email incorrect.";
    }
  } else {
    $error_message = "Veuillez remplir tous les champs";
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Styles/auth.css">
  <title>Connexion - Labo Pharmaceutique</title>
  <link rel="icon" type="image/svg+xml" href="../Assets/icon.svg">
</head>

<body>
  <?php if ($error_message): ?>
    <p class="error"><?php echo htmlspecialchars($error_message) ?></p>
  <?php endif; ?>

  <form action="" method="post">
    <h2>Connectez-vous à votre compte</h2>

    <label for="email-input">Email</label>
    <input type="email" id="email-input" name="email" />

    <label for="pwd-input">Mot de passe</label>
    <input type="password" id="pwd-input" name="passwd" />

    <button type="submit">
      Se Connecter
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-in-icon lucide-log-in">
        <path d="m10 17 5-5-5-5" />
        <path d="M15 12H3" />
        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
      </svg>
    </button>
    <a href="sign_up.php">Créer votre compte ici.</a>
  </form>
</body>

</html>
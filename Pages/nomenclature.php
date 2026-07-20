<?php
session_start();
require "../DAO.php";
if (!isset($_SESSION["user_id"])) {
  header("Location: ../Authentification/login.php");
  exit;
}

$action = $_GET["action"] ?? null;
$ref = $_GET["ref"] ?? null;
$code = $_GET["code"] ?? null;

// Traitement du formulaire (ajout ou modification)
if (isset($_POST["reference_p"]) && isset($_POST["code_m"]) && isset($_POST["dosage"])) {
  $reference_p = $_POST["reference_p"];
  $code_m = $_POST["code_m"];
  $dosage = $_POST["dosage"];

  if ($action === "modifier") {
    DAO::edit_nomenclature($reference_p, $code_m, $dosage);
  } else {
    DAO::add_nomenclature($reference_p, $code_m, $dosage);
  }
  header("Location: nomenclature.php");
  exit;
}

// Suppression
if ($action === "supprimer" && $ref !== null && $code !== null) {
  DAO::delete_nomenclature($ref, $code);
  header("Location: nomenclature.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nomenclature - Labo Pharmaceutique</title>
  <link rel="stylesheet" href="../Styles/main.css">
  <link rel="icon" type="image/svg+xml" href="../Assets/icon.svg">
</head>

<body>
  <header>
    <a href="http://localhost/fil_rouge/">
      <h1>
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-flask-conical-icon lucide-flask-conical">
          <path d="M14 2v6a2 2 0 0 0 .245.96l5.51 10.08A2 2 0 0 1 18 22H6a2 2 0 0 1-1.755-2.96l5.51-10.08A2 2 0 0 0 10 8V2" />
          <path d="M6.453 15h11.094" />
          <path d="M8.5 2h7" />
        </svg>
        Labo Pharmaceutique
      </h1>
    </a>
    <div class="nav-links">
      <a href="http://localhost/fil_rouge/">Accueil</a>
      <a href="./medicaments.php">Médicaments</a>
      <a href="./matiere_premiere.php">Matières premières</a>
      <a href="./stocks.php">Stocks</a>
      <a href="./nomenclature.php" class="active">Nomenclature</a>
      <a href="./besoin.php">Besoin</a>
      <a href="./besoin_mp.php">Besoin MP</a>
      <a href="../Authentification/logout.php" id="logout" title="Se déconnecter" class="logout">
        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="rgb(47, 112, 47)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out">
          <path d="m16 17 5-5-5-5" />
          <path d="M21 12H9" />
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
        </svg>
      </a>
    </div>
  </header>
  <main>
    <?php
    if ($action !== "modifier") {
      $medicaments = DAO::get_medicaments();
      $matieres = DAO::get_matieres_premieres();
      echo '
        <form action="" method="post">
          <h2>Ajouter une nomenclature</h2>
          <div class="row-1 dropdown">
            <select name="reference_p" required>
              <option selected disabled>-- Choisir un médicament --</option>';
      foreach ($medicaments as $med) {
        echo '<option value="' . htmlspecialchars($med["Reference_P"]) . '">' . htmlspecialchars($med["Reference_P"] . ' - ' . $med["Designation"]) . '</option>';
      }
      echo '
        </select>
        <select name="code_m" required>
          <option selected disabled>-- Choisir une matière première --</option>';
      foreach ($matieres as $mp) {
        echo '<option value="' . htmlspecialchars($mp["Code_M"]) . '">' . htmlspecialchars($mp["Code_M"] . ' - ' . $mp["Intitule"]) . '</option>';
      }
      echo '
          </select>
        </div>
        <div class="row-3">
          <input type="number" name="dosage" placeholder="Dosage" step="0.0001" min="0.0001" required>
        </div>
        <button type="submit">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus">
            <path d="M5 12h14"/><path d="M12 5v14"/>
          </svg>
          Ajouter Nomenclature
        </button>
      </form>';
    } else {
      $nom = DAO::get_nomenclature($ref, $code);
      if ($nom) {
        echo '<form action="?action=modifier&ref=' . $ref . '&code=' . $code . '" method="post">';
        echo '<h2>Modifier le dosage</h2>
                <div class="row-1">
                    <input type="text" value="' . htmlspecialchars($nom["Reference_P"]) . '" readonly/>
                    <input type="text" value="' . htmlspecialchars($nom["Code_M"]) . '" readonly/>
                </div>
                <div class="row-3">
                    <input type="number" name="dosage" placeholder="Dosage" step="0.0001" min="0.0001" value="' . htmlspecialchars($nom["Dosage"]) . '" required>
                </div>
                <button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save-plus-icon lucide-save-plus">
                        <path d="M12.5 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h10.2a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V12"/>
                        <path d="M16 13H8a1 1 0 0 0-1 1v7"/><path d="M19 22v-6"/><path d="M22 19h-6"/><path d="M7 3v4a1 1 0 0 0 1 1h7"/>
                    </svg>
                    Sauvegarder les changements
                </button>
                </form>
                ';
      }
    }
    ?>
    <div class="affichage">
      <table>
        <thead>
          <tr>
            <th>Reference_P</th>
            <th>Désignation</th>
            <th>Code_M</th>
            <th>Intitulé</th>
            <th>Dosage</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = DAO::get_nomenclatures();
          if (count($result) > 0) {
            foreach ($result as $row) {
              echo "<tr><td>" . htmlspecialchars($row["Reference_P"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["Designation"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["Code_M"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["Intitule"]) . "</td>";
              echo "<td>" . htmlspecialchars(number_format($row["Dosage"], 4)) . "</td>";
              echo '<td><span><a href="?action=modifier&ref=' . htmlspecialchars($row["Reference_P"]) . '&code=' . htmlspecialchars($row["Code_M"]) . '" title="Modifier"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2f702f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg></a><a href="?action=supprimer&ref=' . htmlspecialchars($row["Reference_P"]) . '&code=' . htmlspecialchars($row["Code_M"]) . '" title="Supprimer"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="rgb(214, 30, 30)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></a></span></td>';
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>
</body>

</html>
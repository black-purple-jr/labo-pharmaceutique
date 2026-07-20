<?php
session_start();
require "../DAO.php";

if (!isset($_SESSION["user_id"])) {
  header("Location: ../Authentification/login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Besoin en Matière Première - Labo Pharmaceutique</title>
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
      <a href="./nomenclature.php">Nomenclature</a>
      <a href="./besoin.php">Besoin</a>
      <a href="./besoin_mp.php" class="active">Besoin MP</a>
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
    <h2 id="mp">Analyse des Besoins en Matières Premières</h2>
    <div class="affichage">
      <h3>1. Besoin Brut Total (par matière première)</h3>
      <table>
        <thead>
          <tr>
            <th>Code_M</th>
            <th>Intitulé</th>
            <th>Besoin Brut Total</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $brut = DAO::get_besoin_brut_mp();
          if (is_array($brut) && count($brut) > 0) {
            foreach ($brut as $row) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row["code_M"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["Intitule"]) . "</td>";
              echo "<td>" . htmlspecialchars(number_format($row["S_besoin_brut"], 3, ',', ' ')) . "</td>";
              echo "</tr>";
            }
          } else {
            echo '<tr><td colspan="3" style="text-align:center; padding: 20px;">Aucun besoin brut calculé.</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- Tableau 2 : Besoin Net -->
    <div class="affichage" style="margin-top: 40px;">
      <h3>2. Besoin Net à Commander (après déduction du stock)</h3>
      <table>
        <thead>
          <tr>
            <th>Code_M</th>
            <th>Intitulé</th>
            <th>Besoin Brut</th>
            <th>Stock Actuel</th>
            <th>Besoin Net (à commander)</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $net = DAO::get_besoin_net_mp();
          if (is_array($net) && count($net) > 0) {
            foreach ($net as $row) {
              // Mise en forme conditionnelle : rouge si on doit commander, vert si le stock est suffisant
              $style = ($row["besoin_net"] > 0) ? 'color: #d61e1e; font-weight: bold;' : 'color: #2f702f; font-weight: bold;';
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row["code_M"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["Intitule"]) . "</td>";
              echo "<td>" . htmlspecialchars(number_format($row["S_besoin_brut"], 3, ',', ' ')) . "</td>";
              echo "<td>" . htmlspecialchars(number_format($row["Qte_stock"], 3, ',', ' ')) . "</td>";
              echo "<td style='" . $style . "'>" . htmlspecialchars(number_format($row["besoin_net"], 3, ',', ' ')) . "</td>";
              echo "</tr>";
            }
          } else {
            echo '<tr><td colspan="5" style="text-align:center; padding: 20px;">Aucun besoin net calculé.</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>
</body>

</html>
<?php
session_start();
require "../DAO.php";
if (!isset($_SESSION["user_id"])) {
  header("Location: ../Authentification/login.php");
  exit;
}

// Determine which tab is active
$view = $_GET['view'] ?? 'med';

// Fetch data based on the selected tab
if ($view === 'med') {
  $stocks = DAO::get_stocks_med();
} else {
  $stocks = DAO::get_stocks_mp();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stocks - Labo Pharmaceutique</title>
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
      <a href="./stocks.php" class="active">Stocks</a>
      <a href="./nomenclature.php">Nomenclature</a>
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
    <div class="tabs">
      <a href="?view=med" class="tab <?= $view === 'med' ? 'active' : '' ?>">Stock Médicaments</a>
      <a href="?view=mp" class="tab <?= $view === 'mp' ? 'active' : '' ?>">Stock Matières Premières</a>
    </div>
    <div class="affichage">
      <table>
        <thead id="head">
          <tr>
            <?php if ($view === 'med'): ?>
              <th>Reference_P</th>
              <th>Désignation</th>
              <th>Mois</th>
              <th>Quantité en Stock</th>
            <?php else: ?>
              <th>Code_M</th>
              <th>Intitulé</th>
              <th>Mois</th>
              <th>Quantité en Stock</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
          <?php if (count($stocks) > 0): ?>
            <?php foreach ($stocks as $row): ?>
              <tr>
                <?php if ($view === 'med'): ?>
                  <td><?= htmlspecialchars($row["Reference_P"]) ?></td>
                  <td><?= htmlspecialchars($row["Designation"]) ?></td>
                  <td><?= htmlspecialchars($row["N_Mois"]) ?></td>
                  <td><?= htmlspecialchars($row["Quantite_Stock"]) ?></td>
                <?php else: ?>
                  <td><?= htmlspecialchars($row["Code_M"]) ?></td>
                  <td><?= htmlspecialchars($row["Intitule"]) ?></td>
                  <td><?= htmlspecialchars($row["N_Mois"]) ?></td>
                  <td><?= htmlspecialchars(number_format($row["Quantite_Stock"], 3)) ?></td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" style="text-align: center; padding: 20px;">Aucune donnée de stock trouvée.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
</body>

</html>
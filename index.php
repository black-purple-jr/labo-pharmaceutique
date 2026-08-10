<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: Authentification/login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil - Labo Pharmaceutique</title>
  <link rel="stylesheet" href="Styles/main.css">
  <link rel="icon" type="image/svg+xml" href="Assets/icon.svg">
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
      <a href="http://localhost/fil_rouge/" class="active">Accueil</a>
      <a href="Pages/medicaments.php">Médicaments</a>
      <a href="Pages/matiere_premiere.php">Matières premières</a>
      <a href="Pages/stocks.php">Stocks</a>
      <a href="Pages/nomenclature.php">Nomenclature</a>
      <a href="Pages/besoin.php">Besoin</a>
      <a href="Pages/besoin_mp.php">Besoin MP</a>
      <a href="Authentification/logout.php" id="logout" title="Se déconnecter" class="logout">
        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="rgb(47, 112, 47)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out">
          <path d="m16 17 5-5-5-5" />
          <path d="M21 12H9" />
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
        </svg>
      </a>
    </div>
  </header>
  <main>
    <div class="banner">
      <h1>Gestion des produits pharmaceutique</h1>
      <h2>Les médicaments, les lots, les matières premières et plus...</h2>
    </div>
    <div class="container">
      <a href="./Pages/medicaments.php">
        <div class="card">
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="rgb(47, 112, 47)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pill-icon lucide-pill">
              <path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z" />
              <path d="m8.5 8.5 7 7" />
            </svg>
          </div>
          <div class="text">Ajouter, modifier et supprimer des médicaments</div>
        </div>
      </a>
      <a href="./Pages/matiere_premiere.php">
        <div class="card">
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="rgb(47, 112, 47)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-flask-conical-icon lucide-flask-conical">
              <path d="M14 2v6a2 2 0 0 0 .245.96l5.51 10.08A2 2 0 0 1 18 22H6a2 2 0 0 1-1.755-2.96l5.51-10.08A2 2 0 0 0 10 8V2" />
              <path d="M6.453 15h11.094" />
              <path d="M8.5 2h7" />
            </svg>
          </div>
          <div class="text">Gérer et manipuler les matières premières et leurs dosages dans les médicaments</div>
        </div>
      </a>
      <a href="./Pages/stocks.php">
        <div class="card">
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="rgb(47, 112, 47)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-container-icon lucide-container">
              <path d="M22 7.7c0-.6-.4-1.2-.8-1.5l-6.3-3.9a1.72 1.72 0 0 0-1.7 0l-10.3 6c-.5.2-.9.8-.9 1.4v6.6c0 .5.4 1.2.8 1.5l6.3 3.9a1.72 1.72 0 0 0 1.7 0l10.3-6c.5-.3.9-1 .9-1.5Z" />
              <path d="M10 21.9V14L2.1 9.1" />
              <path d="m10 14 11.9-6.9" />
              <path d="M14 19.8v-8.1" />
              <path d="M18 17.5V9.4" />
            </svg>
          </div>
          <div class="text">Calculer et gérer les stocks des médicaments et des matières premières</div>
        </div>
      </a>
      <a href="./Pages/nomenclature.php">
        <div class="card">
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="rgb(47, 112, 47)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-list-icon lucide-clipboard-list">
              <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
              <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
              <path d="M12 11h4" />
              <path d="M12 16h4" />
              <path d="M8 11h.01" />
              <path d="M8 16h.01" />
            </svg>
          </div>
          <div class="text">Gérer le dosage et les compositions des médicaments</div>
        </div>
      </a>
      <a href="./Pages/besoin.php">
        <div class="card">
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="rgb(47, 112, 47)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-scroll-text-icon lucide-scroll-text">
              <path d="M15 12h-5" />
              <path d="M15 8h-5" />
              <path d="M19 17V5a2 2 0 0 0-2-2H4" />
              <path d="M8 21h12a2 2 0 0 0 2-2v-1a1 1 0 0 0-1-1H11a1 1 0 0 0-1 1v1a2 2 0 1 1-4 0V5a2 2 0 1 0-4 0v2a1 1 0 0 0 1 1h3" />
            </svg>
          </div>
          <div class="text">Gérer les besoins des matières premières et plus...</div>
        </div>
      </a>
    </div>
  </main>
</body>

</html>
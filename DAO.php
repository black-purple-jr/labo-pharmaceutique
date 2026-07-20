<?php
require __DIR__ . "/Plan.php";

class DAO implements Plan
{
  // ______METHODE DE CONNEXION AU SERVEUR DE DONNEES________
  public static function connect(): PDO
  {
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "labo";
    try {
      $dsn = "mysql:host=$server;dbname=$database";
      $pdo = new PDO($dsn, $username, $password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    } catch (Exception $e) {
      echo "Erreur de connexion: " . $e->getMessage();
      throw $e;
    }
  }

  // ______METHODES POUR GERER LES UTILISATEURS_________
  public static function get_user(string $email): array|false
  {
    $pdo = self::connect();
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  public static function create_user(string $email, string $passwd): bool
  {
    $pdo = self::connect();
    $query = "INSERT INTO users (email, password_hash) VALUES (?, ?)";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$email, $passwd]);
    return $result;
  }

  // ______METHODES POUR GERER LES MEDICAMENTS_________
  public static function add_medicament(string $reference_p, string $designation, string $descriptif, string $forme, float $ppm, int $t_lot): bool
  {
    $pdo = self::connect();
    $query = "INSERT INTO medicament (Reference_P, Designation, Descriptif, Forme, PPM, T_Lot) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$reference_p, $designation, $descriptif, $forme, $ppm, $t_lot]);
    return $result;
  }

  public static function get_medicament(string $reference_p): array|false
  {
    $pdo = self::connect();
    $query = "SELECT * FROM medicament WHERE Reference_P = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$reference_p]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  public static function edit_medicament(string $reference_p, string $designation, string $descriptif, string $forme, float $ppm, int $t_lot): bool
  {
    $pdo = self::connect();
    $query = "UPDATE medicament SET Designation = ?, Descriptif = ?, Forme = ?, PPM = ?, T_Lot = ? WHERE Reference_P = ?";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$designation, $descriptif, $forme, $ppm, $t_lot, $reference_p]);
    return $result;
  }

  public static function delete_medicament(string $reference_p): bool
  {
    $pdo = self::connect();
    $query = "DELETE FROM medicament WHERE Reference_P = ?";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$reference_p]);
    return $result;
  }

  public static function get_medicaments(): array
  {
    $pdo = self::connect();
    $query = "SELECT * FROM medicament";
    $stmt = $pdo->prepare($query);
    $stmt->execute([]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return is_array($result) ? $result : [];
  }

  // ______METHODES POUR GERER LES MATIERES PREMIERES_________
  public static function add_matiere_premiere(string $code_m, string $intitule, string $provenance): bool
  {
    $pdo = self::connect();
    $query = "INSERT INTO matiere_premiere (Code_M, Intitule, Provenance) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$code_m, $intitule, $provenance]);
    return $result;
  }

  public static function get_matiere_premiere(string $code_m): array|false
  {
    $pdo = self::connect();
    $query = "SELECT * FROM matiere_premiere WHERE Code_M = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$code_m]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  public static function edit_matiere_premiere(string $code_m, string $intitule, string $provenance): bool
  {
    $pdo = self::connect();
    $query = "UPDATE matiere_premiere SET Intitule = ?, Provenance = ? WHERE Code_M = ?";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$intitule, $provenance, $code_m]);
    return $result;
  }

  public static function delete_matiere_premiere(string $code_m): bool
  {
    $pdo = self::connect();
    $query = "DELETE FROM matiere_premiere WHERE Code_M = ?";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$code_m]);
    return $result;
  }

  public static function get_matieres_premieres(): array
  {
    $pdo = self::connect();
    $query = "SELECT * FROM matiere_premiere";
    $stmt = $pdo->prepare($query);
    $stmt->execute([]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return is_array($result) ? $result : [];
  }

  // ______METHODES POUR GERER LES STOCKS_________
  public static function get_stocks_med(): array
  {
    $pdo = self::connect();
    $query = "SELECT sm.Reference_P, m.Designation, sm.N_Mois, sm.Quantite_Stock FROM stocke_med sm JOIN medicament m ON sm.Reference_P = m.Reference_P ORDER BY sm.N_Mois ASC, sm.Reference_P ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return is_array($result) ? $result : [];
  }

  public static function get_stocks_mp(): array
  {
    $pdo = self::connect();
    $query = "SELECT smp.Code_M, mp.Intitule, smp.N_Mois, smp.Quantite_Stock FROM stocke_mp smp JOIN matiere_premiere mp ON smp.Code_M = mp.Code_M ORDER BY smp.N_Mois ASC, smp.Code_M ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return is_array($result) ? $result : [];
  }

  // ______METHODES POUR GERER LA NOMENCLATURE_________
  public static function get_nomenclatures(): array
  {
    $pdo = self::connect();
    $query = "SELECT n.Reference_P, m.Designation, n.Code_M, mp.Intitule, n.Dosage FROM nomenclature n JOIN medicament m ON n.Reference_P = m.Reference_P JOIN matiere_premiere mp ON n.Code_M = mp.Code_M ORDER BY n.Reference_P ASC, n.Code_M ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return is_array($result) ? $result : [];
  }

  public static function get_nomenclature(string $reference_p, string $code_m): array|false
  {
    $pdo = self::connect();
    $query = "SELECT * FROM nomenclature WHERE Reference_P = ? AND Code_M = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$reference_p, $code_m]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  public static function add_nomenclature(string $reference_p, string $code_m, float $dosage): bool
  {
    $pdo = self::connect();
    $query = "INSERT INTO nomenclature (Reference_P, Code_M, Dosage) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$reference_p, $code_m, $dosage]);
    return $result;
  }

  public static function edit_nomenclature(string $reference_p, string $code_m, float $dosage): bool
  {
    $pdo = self::connect();
    $query = "UPDATE nomenclature SET Dosage = ? WHERE Reference_P = ? AND Code_M = ?";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$dosage, $reference_p, $code_m]);
    return $result;
  }

  public static function delete_nomenclature(string $reference_p, string $code_m): bool
  {
    $pdo = self::connect();
    $query = "DELETE FROM nomenclature WHERE Reference_P = ? AND Code_M = ?";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$reference_p, $code_m]);
    return $result;
  }

  // ______METHODES POUR GERER LES BESOINS_________
  public static function get_besoins(): array
  {
    $pdo = self::connect();
    $query = "SELECT b.N_Mois, b.Reference_P, m.Designation, b.Quantite 
                  FROM besoin b 
                  JOIN medicament m ON b.Reference_P = m.Reference_P 
                  ORDER BY b.N_Mois ASC, b.Reference_P ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return is_array($result) ? $result : [];
  }

  public static function get_besoin(int $n_mois, string $reference_p): array|false
  {
    $pdo = self::connect();
    $query = "SELECT * FROM besoin WHERE N_Mois = ? AND Reference_P = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$n_mois, $reference_p]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  public static function add_besoin(int $n_mois, string $reference_p, int $quantite): bool
  {
    $pdo = self::connect();
    $query = "INSERT INTO besoin (N_Mois, Reference_P, Quantite) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$n_mois, $reference_p, $quantite]);
    return $result;
  }

  public static function edit_besoin(int $n_mois, string $reference_p, int $quantite): bool
  {
    $pdo = self::connect();
    $query = "UPDATE besoin SET Quantite = ? WHERE N_Mois = ? AND Reference_P = ?";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$quantite, $n_mois, $reference_p]);
    return $result;
  }

  public static function delete_besoin(int $n_mois, string $reference_p): bool
  {
    $pdo = self::connect();
    $query = "DELETE FROM besoin WHERE N_Mois = ? AND Reference_P = ?";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$n_mois, $reference_p]);
    return $result;
  }

  public static function get_besoin_brut_mp(): array
  {
    $pdo = self::connect();
    $query = "SELECT v.code_M, mp.Intitule, v.S_besoin_brut FROM v_sum_besoin_brut_mp v JOIN matiere_premiere mp ON v.code_M = mp.Code_M ORDER BY v.code_M ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return is_array($result) ? $result : [];
  }

  public static function get_besoin_net_mp(): array
  {
    $pdo = self::connect();
    $query = "SELECT v.code_M, mp.Intitule, v.S_besoin_brut, v.Qte_stock, v.besoin_net FROM v_besoin_net_mp v JOIN matiere_premiere mp ON v.code_M = mp.Code_M ORDER BY v.code_M ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return is_array($result) ? $result : [];
  }
}

<?php
// les signatures des méthodes de la classe DAO
interface Plan
{
  public static function connect(): PDO;

  // ______UTILISATEURS_________
  public static function get_user(string $email): array|false;
  public static function create_user(string $email, string $passwd): bool;

  // ______MEDICAMENTS_________
  public static function add_medicament(string $reference_p, string $designation, string $descriptif, string $forme, float $ppm, int $t_lot): bool;
  public static function get_medicament(string $reference_p): array|false;
  public static function edit_medicament(string $reference_p, string $designation, string $descriptif, string $forme, float $ppm, int $t_lot): bool;
  public static function delete_medicament(string $reference_p): bool;
  public static function get_medicaments(): array;

  // ______MATIERES PREMIERES_________
  public static function add_matiere_premiere(string $code_m, string $intitule, string $provenance): bool;
  public static function get_matiere_premiere(string $code_m): array|false;
  public static function edit_matiere_premiere(string $code_m, string $intitule, string $provenance): bool;
  public static function delete_matiere_premiere(string $code_m): bool;
  public static function get_matieres_premieres(): array;

  // ______STOCKS_________
  public static function get_stocks_med(): array;
  public static function get_stocks_mp(): array;

  // ______NOMENCLATURE_________
  public static function get_nomenclatures(): array;
  public static function get_nomenclature(string $reference_p, string $code_m): array|false;
  public static function add_nomenclature(string $reference_p, string $code_m, float $dosage): bool;
  public static function edit_nomenclature(string $reference_p, string $code_m, float $dosage): bool;
  public static function delete_nomenclature(string $reference_p, string $code_m): bool;

  // ______BESOINS_________
  public static function get_besoins(): array;
  public static function get_besoin(int $n_mois, string $reference_p): array|false;
  public static function add_besoin(int $n_mois, string $reference_p, int $quantite): bool;
  public static function edit_besoin(int $n_mois, string $reference_p, int $quantite): bool;
  public static function delete_besoin(int $n_mois, string $reference_p): bool;

  // ______UTILISATION DES VUES________
  public static function get_besoin_brut_mp(): array;
  public static function get_besoin_net_mp(): array;
}

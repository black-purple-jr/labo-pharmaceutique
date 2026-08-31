# Labo Pharmaceutique

## Aperçu

C'est une application Web construite avec HTML, CSS et PHP qui permet à un laboratoire d’industrie pharmaceutique de digitaliser une partie de son système 
d’information afin de mieux gérer la traçabilité des médicaments et des matières 
premières.

## Caractéristiques

* La gestion des médicaments.
* Le suivi des matières premières.
* La gestion des stocks mensuels.
* Le lancement de production par lot.
* Calcul automatique des besoins nets en matières premières.
* Authentification par session (connexion / inscription / déconnexion).

## Architecture

* Accès aux données via le modèle **DAO** (`DAO.php`) en s'aidant de la classe **PDO**, pour séparer la logique métier de l'accès base de données et pour une connexion plus sécurisée.
* Authentification basée sur les sessions PHP (`$_SESSION[]`).
* Base de données `labo` avec :
  * une fonction stockée `F_Calcul` pour le calcul du besoin net,
  * des vues (`v_besoin_med`, `v_besoin_brut_mp`, `v_sum_besoin_brut_mp`, `v_besoin_net_mp`) qui gèrent l'arrondi par taille de lot, le besoin brut en matières premières via la nomenclature, et le besoin net après déduction du stock.


## Technologie utilisée

* HTML & CSS pour le côté client.
* PHP pour le côté serveur.
* MySQL pour la gestion des données.

## Licence

Ce projet est sous la licence de MIT - voir la [LICENSE](LICENSE) pour plusieurs de détails.

## Auteur

* Abdellah DAKIR ALLAH - [black-purple-jr](https://github.com/black-purple-jr) sur Github et d'autres plateformes.
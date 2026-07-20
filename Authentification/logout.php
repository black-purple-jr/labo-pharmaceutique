<?php

session_start();
session_unset(); // vider tous les clés avec leurs valeur du tableau associatif $_SESSION
session_destroy(); // détruire la session courante

header("Location: ../index.php"); // ça vas vous diriger au formulaire d'authentification
exit;
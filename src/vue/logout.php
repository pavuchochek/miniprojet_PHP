<?php
    // Démarre la session
    session_start();

    // Détruit toutes les données de la session
    session_destroy();

    // Redirige vers la page de connexion
    header("Location: login.php");
    exit(); // Assure que le script s'arrête après la redirection
?>

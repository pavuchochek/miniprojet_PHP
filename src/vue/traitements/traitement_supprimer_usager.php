<?php
    require('../../controleur/usager.controleur.php');

    $controleur = new Usager_controleur();
    $idUsager = $_GET["id"];
    $controleur->supprimer_usager($idUsager);
    header('Location: /usagers.php');
?>
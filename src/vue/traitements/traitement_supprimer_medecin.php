<?php
    require('../../controleur/medecin.controleur.php');

    $controleur = new Medecin_controleur();
    $id=$_GET["id"];
    $controleur->supprimer_medecin($id);
    header('Location: /medecins.php');
?>

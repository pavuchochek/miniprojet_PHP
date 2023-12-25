<?php
    require('../controleur/medecin.controleur.php');

    $controleur = new Medecin_controleur();
    $nom=$_POST["nom"];
    $prenom=$_POST["prenom"];
    $civilite=$_POST["civilite"];
    $controleur->ajouter_medecin($nom,$prenom,$civilite);
    header('Location: medecins.php');
?>

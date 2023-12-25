<?php
    require('../controleur/medecin.controleur.php');

    $controleur = new Medecin_controleur();
    $nom=$_POST["nom"];
    $nom = preg_replace("/[^a-zA-Z]/", "", $nom);
    $prenom=$_POST["prenom"];
    $prenom = preg_replace("/[^a-zA-Z]/", "", $prenom);
    $civilite=$_POST["civilite"];
    $controleur->ajouter_medecin($nom,$prenom,$civilite);
    header('Location: medecins.php');
?>

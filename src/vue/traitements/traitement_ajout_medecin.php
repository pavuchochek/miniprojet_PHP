<?php
    require('/app/src/controleur/medecin.controleur.php');

    $controleur = new Medecin_controleur();
    $nom = $_POST["nom"];
    $nom = preg_replace("/[^a-zA-Z\-]/", "", $nom);
    $nom = ucfirst(strtolower($nom));
    $prenom = $_POST["prenom"];
    $prenom = preg_replace("/[^a-zA-Z\-]/", "", $prenom);
    $prenom = ucfirst(strtolower($prenom));
    $nom = preg_replace_callback("/-(.)/", function($matches) {
        return '-' . strtoupper($matches[1]);
    }, $nom);
    $prenom = preg_replace_callback("/-(.)/", function($matches) {
        return '-' . strtoupper($matches[1]);
    }, $prenom);
    $civilite=$_POST["civilite"];
    $controleur->ajouter_medecin($nom,$prenom,$civilite);
    header('Location: /medecins.php');
?>

<?php
    require('../../controleur/usager.controleur.php');

    $controleur = new Usager_controleur();
    $nom = $_POST["nom"];
    $nom = preg_replace("/[^a-zA-Z]/", "", $nom);
    $prenom = $_POST["prenom"];
    $prenom = preg_replace("/[^a-zA-Z]/", "", $prenom);
    $civilite = $_POST["civilite"];
    $adresse = $_POST["Adresse"];
    $dateNaissance = $_POST["dateNaissance"];
    $lieuNaissance = $_POST["lieuNaissance"];
    $numeroSecu = $_POST["Numero_Secu"];
    $medecinReferent = $_POST["medecinReferent"];
    $idUsager = $_POST["idUsager"];

    $controleur->modifier_usager($nom, $prenom, $civilite, $adresse, $dateNaissance, $lieuNaissance, $numeroSecu, $medecinReferent, $idUsager);

    header('Location: /usagers.php');
?>
<?php
    require('/app/src/controleur/usager.controleur.php');

    $controleur = new Usager_controleur();
    $nom=$_POST["nom"];
    $nom = preg_replace("/[^a-zA-Z]/", "", $nom);
    $prenom=$_POST["prenom"];
    $prenom = preg_replace("/[^a-zA-Z]/", "", $prenom);
    $civilite=$_POST["civilite"];
    $adresse=$_POST["Adresse"];
    $dateNaissance=$_POST["dateNaissance"];
    $lieuNaissance=$_POST["lieuNaissance"];
    $Numero_Secu=$_POST["Numero_Secu"];
    $medecinReferent = isset($_POST["medecinReferent"]) ? intval($_POST["medecinReferent"]) : null;
    $controleur->ajouter_usager($nom, $prenom, $civilite, $adresse, $dateNaissance, $lieuNaissance, $Numero_Secu, $medecinReferent);
    
    header('Location: /usagers.php');
?>
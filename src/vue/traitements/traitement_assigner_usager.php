<?php
    require('../../controleur/usager.controleur.php');

    $controleur = new Usager_controleur();
    $medecinReferent = isset($_POST["medecinReferent"]) ? intval($_POST["medecinReferent"]) : null;
    $idUsager = $_POST["idUsager"];
    $usager = $controleur->getUsagerById($idUsager);
    $adresse = $usager->getAdresse();
    $dateNaissance = $usager->getDateNaissance();
    $lieuNaissance = $usager->getLieuNaissance();
    $numeroSecu = $usager->getNsecuriteSociale();
    $nom = $usager->getNom();
    $prenom = $usager->getPrenom();
    $civilite = $usager->getCivilite();

    $controleur->modifier_usager($idUsager, $nom, $prenom, $civilite, $adresse, $dateNaissance, $lieuNaissance, $numeroSecu, $medecinReferent);

    header('Location: /detail_medecin.php?id='.$medecinReferent);
?>
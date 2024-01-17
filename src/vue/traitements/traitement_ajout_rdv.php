<?php
    require('/app/src/controleur/rdv.controleur.php');

    $controleur = new Rdv_Controleur();
    $patient = $_POST["usager"];
    $medecin = $_POST["medecin"];
    $date = $_POST["date"];
    $heure_debut = $_POST["heure_debut"];
    $heure_fin = $_POST["heure_fin"];
    $controleur->creationRdv($patient,$medecin,$date,$heure_debut,$heure_fin);
    header('Location: /rdv.php');
?>

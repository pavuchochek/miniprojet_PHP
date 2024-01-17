<?php
    require('../../controleur/rdv.controleur.php');

    $controleur = new Rdv_controleur();
    $idmedecin=$_GET["idMedecin"];
    $idusager=$_GET["idUsager"];
    $date=$_GET["date"];
    $heureDebut=$_GET["heureDebut"];
    $heurefin=$_GET["heurefin"];
    $controleur->supprimer_rdv($idmedecin,$idusager,$date,$heureDebut,$heurefin);
    header('Location: /medecins.php');
?>

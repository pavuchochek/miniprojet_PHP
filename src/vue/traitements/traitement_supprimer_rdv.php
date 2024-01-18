<?php
    require('../../controleur/rdv.controleur.php');

    $controleur = new Rdv_controleur();
    $idmedecin=$_GET["idmedecin"];
    $idusager=$_GET["idusager"];
    $date=$_GET["date"];
    $heureDebut=$_GET["heureDebut"];
    $heurefin=$_GET["heureFin"];
    $controleur->suppressionRdv($idmedecin,$idusager,$date,$heureDebut,$heurefin);
    header('Location: /rdv.php');
?>

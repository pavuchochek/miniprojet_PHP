<?php
    require('../../controleur/usager.controleur.php');

    $controleur = new Usager_controleur();
    $id = $_GET["id"];
    $idMedecin = $_GET["idMedecin"];
    $controleur-> supprimer_medecin_byUsagerId($idMedecin,$id);

    header ('Location: /detail_medecin.php?id='.$idMedecin);
?>
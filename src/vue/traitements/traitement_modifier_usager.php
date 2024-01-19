<?php
    require('../../controleur/usager.controleur.php');

    $controleur = new Usager_controleur();
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
    $civilite = $_POST["civilite"];
    $adresse = $_POST["Adresse"];
    $dateNaissance = $_POST["dateNaissance"];
    $lieuNaissance = $_POST["lieuNaissance"];
    $numeroSecu = $_POST["Numero_Secu"];
    $medecinReferent = isset($_POST["medecinReferent"]) ? intval($_POST["medecinReferent"]) : null;
    //$erreur=$controleur->isNumeroSecuDejaUtilise($numeroSecu);
    $dateActuelle = date('Y-m-d');
    if ($dateNaissance > $dateActuelle) {
        echo "La date de naissance ne peut pas être supérieure à la date actuelle.";
        echo "<br>";
        echo "<a href='/usagers.php'>Go back</a>";
        exit;
    }
    /*if($erreur=true){
        echo "Ce numero de securité est deja present dans la base";
        echo "<br>";
        echo "<a href='/usagers.php'>Go back</a>";
        exit;
    }else{*/
        $idUsager = $_POST["idUsager"];
        $controleur->modifier_usager($idUsager, $nom, $prenom, $civilite, $adresse, $dateNaissance, $lieuNaissance, $numeroSecu, $medecinReferent);
        header('Location: /usagers.php');
    //}
?>
<?php clearstatcache();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Medecins</title>
        <link rel="stylesheet" href="css/CSSmedecin.css">
        <link rel="stylesheet" href="css/CSSheader.css">
        <link rel="stylesheet" href="css/CSSfooter.css">
    </head>

    <?php include 'header.php'; ?>

    <body>
        <div class="body">
            <h1>Liste des medecins</h1>

            <div class="box_medecin">
                <?php
                    require('../controleur/medecin.controleur.php');
                    $controleur = new Medecin_controleur();
                    $resultat=$controleur->liste_medecins();
                    foreach ($resultat as $value){
                        echo "<div class='item_medecin'>
                        <img class='icone_liste_medecin' src='img/icone_homme.png' alt='icone d'un medecin'/>
                        <div class='nom'>".$value->getNom()."</div>"."<div>".$value->getPrenom()."</div></div>";
                    }
                ?>
            </div>

            <div class="boutons_modif" >
                <input type="button" value="Ajouter un medecin">
            </div>
        </div>
    </body>
    
    <?php include 'footer.php'; ?>
</html>
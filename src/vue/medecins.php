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
        <link rel="icon" href="img/logo.png">
    </head>

    <?php include 'header.php'; ?>

    <body>
        <div class="body">

            <div id="formulaire">
                <form method="post" action="traitement_ajout_medecin.php">
                    <label for="nom">Nom:</label>
                    <input type="text" id="nom" name="nom">
                    <label for="prenom">Prénom:</label>
                    <input type="text" id="prenom" name="prenom">
                    <label for="civilite">Civilité:</label>
                    <select id="civilite" name="civilite">
                        <option value="M">Monsieur</option>
                        <option value="F">Madame</option>
                        <option value="A">Autre</option>
                    </select>
                    <input type="submit" value="Envoyer">
                </form>
            </div>
            <div class="recherche">
                <form action="" method="GET">
                    <input type="text" name="search" placeholder="Rechercher un médecin">
                    <input type="submit" value="Rechercher">
                </form>
            </div>
            <div class="box_medecin" id="list_medecin">
                <?php
                    require('../controleur/medecin.controleur.php');
                    $controleur = new Medecin_controleur();
                    $resultat=$controleur->liste_medecins();
                    foreach ($resultat as $value){
                        if ($value->getCivilite() === 'M') {
                            $genderIcon = 'icone_homme.png';
                        } else if ($value->getCivilite() === 'F'){
                            $genderIcon = 'icone_femme.png';
                        } else {
                            $genderIcon = 'icone_menu_usager.png';
                        }
                        echo "<div class='item_medecin'>
                        <img class='icone_liste_medecin' src='img/$genderIcon' alt='icone d'un medecin'/>
                        <div class='nom'>".$value->getNom()."</div>"."<div>".$value->getPrenom()."</div></div>";
                    }
                ?>
            </div>

            <div class="boutons_modif" id="afficherFormulaire">
                <input type="button" value="Ajouter un medecin">
            </div>
        </div>
    </body>
    
    <?php include 'footer.php'; ?>
    <script>
        var list = document.getElementById('list_medecin');
        document.getElementById('afficherFormulaire').addEventListener('click', function() {
            var formulaire = document.getElementById('formulaire');
            var list = document.getElementById('list_medecin');
            if (formulaire.style.display == 'block') {
                formulaire.style.display = 'none';
                list.style.display = 'block';
            } else {
                formulaire.style.display = 'block';
                list.style.display = 'none';
            }
        });
        document.addEventListener('DOMContentLoaded', flecheHaut);
        formulaire.style.display = 'none';
        list.style.display = 'block';
    </script>
</html>
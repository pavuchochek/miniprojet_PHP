<!DOCTYPE html>
<html lang="fr">
<head>
        <meta charset="utf-8" />
        <title>Usagers</title>
        <link rel="stylesheet" href="css/CSSusager.css">
        <link rel="stylesheet" href="css/CSSheader.css">
        <link rel="stylesheet" href="css/CSSfooter.css">
        <link rel="icon" href="img/logo.png">
    </head>

    <?php include 'header.php'; ?>

    <body>
        <div class="body">
            <h1>Liste des patients</h1>
            <?php
                    require('../controleur/usager.controleur.php');
                    $controleur = new Usager_Controleur();
                    $resultat = $controleur->liste_usagers();
                    foreach ($resultat as $value){
                        $prenom = $value->getPrenom();
                        $nom = $value->getNom();
                        $civilite= $value->getCivilite();
                        $medecinRef = $value->getMedecinReferent();
                        /*attention faut pas que ça soit null !!!*/
                        if(is_null($medecinRef)){
                            $medecinRef = "Pas de medecin referent";
                        }else{
                            $medecinRef=$medecinRef->toString();
                        }
                        echo "
                            <div class='item_medecin'>
                                <div>
                                    <div class='nom'>"
                                        .$prenom ." ".$nom." ". $civilite ." ".$medecinRef;
                                    "</div>
                                </div>
                            </div>";
                    }
            ?>
            <div class="boutons_modif" >
                <input type="button" value="Ajouter un patient">
            </div>
        </div>
    </body>

    <?php include 'footer.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', flecheHaut);
    </script>
</html>
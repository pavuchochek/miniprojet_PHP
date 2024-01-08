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
            <div class="box_usagers" id="list_usagers">
                <?php
                        require('../controleur/usager.controleur.php');
                        $controleur = new Usager_Controleur();
                        $resultat = $controleur->liste_usagers();
                        foreach ($resultat as $value){
                            $prenom = $value->getPrenom();
                            $nom = $value->getNom();
                            $medecinRef = $value->getMedecinReferent();
                            if ($value->getCivilite() === 'M') {
                                $genderIcon = 'icone_homme_usager.png';
                            } else if ($value->getCivilite() === 'F'){
                                $genderIcon = 'icone_femme_usager.png';
                            } else {
                                $genderIcon = 'icone_autre.png';
                            }
                            if(is_null($medecinRef)){
                                $medecinRef = "∅";
                            }else{
                                $medecinRef=$medecinRef->getNom();
                            }
                            echo "
                                <a class='lien_medecin'>".
                                // ajouter le lien vers la page detail_usager quand la page sera faite
                                    "<div class='item_usager'>
                                        <img class='icone_liste_usager' src='img/$genderIcon' alt='icone d'un medecin'/>
                                        <div>
                                            <div class='nom'><p>"
                                                .$prenom . "<br>"
                                                .$nom. "<br>Médecin : "
                                                .$medecinRef.
                                            "</p></div>
                                            <div class='boutonsusager'>
                                                <a href='modifier_usager.php?prenom=$prenom&nom=$nom'>
                                                    <img class='icone_modifier' src='img/icone_modifier.png' alt='icone modifier'/>".
                                                    // ajouter l'action modifier usager quand la page usager sera faite
                                                "</a>
                                                <a href='#' class='supprimerMedecinBtn' data-prenom='$prenom' data-nom='$nom'>
                                                    <img class='icone_supprimer' src='img/icone_supprimer.png' alt='icone supprimer'/>".
                                                    // ajouter l'action modifier usager quand la page usager sera faite
                                                " </a>
                                            </div>
                                        </div>
                                    </div>
                                </a>";
                        }
                ?>
            </div>
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
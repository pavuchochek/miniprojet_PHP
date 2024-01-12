<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Rendez-vous</title>
        <link rel="stylesheet" href="css/CSSrdv.css">
        <link rel="stylesheet" href="css/CSSheader.css">
        <link rel="stylesheet" href="css/CSSfooter.css">
        <link rel="icon" href="img/logo.png">
    </head>

    <?php include 'header.php'; ?>

    <body>
        <div class="body">
            <h1>Liste des rendez-vous</h1>  
            <div class="boutons_modif" >
                <input type="button" value="Ajouter un rendez-vous">
            </div>
            <?php
                require('/app/src/controleur/rdv.controleur.php');
                $controleur = new Rdv_controleur();
                $resultat = $controleur->liste_rdv();
                foreach ($resultat as $value){
                    $date = $value->getDateRdvString();
                    $heure = $value->getHeureDebut();
                    $nom_usager = $value->getUsager()->getNom();
                    $prenom_usager = $value->getUsager()->getPrenom();
                    echo "
                    <div class='rdv'>
                        <div>
                            <div class='rdvinfo'>
                                <h3>$date :</h3>
                                <p>$heure</p>
                            </div>
                            <p>Patient : $nom_usager $prenom_usager</p>
                        </div>
                    </div>";
                }
            ?>
        </div>
    </body>

    <?php include 'footer.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', flecheHaut);
    </script>
</html>
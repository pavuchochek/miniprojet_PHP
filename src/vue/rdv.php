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
            <div class="boutons_modif" >
                <input type="button" value="Ajouter un rendez-vous">
            </div>
            <div class="card-container">
            <?php
                require('/app/src/controleur/rdv.controleur.php');
                $controleur = new Rdv_controleur();
                $resultat = $controleur->liste_rdv();
                foreach ($resultat as $value){
                    $date = $value->getDateRdvString();
                    $heure_debut = $value->getHeureDebut();
                    $heure_debut = substr($heure_debut, 0, -3);
                    $heure_fin = $value->getHeureFin();
                    $heure_fin = substr($heure_fin, 0, -3);
                    $nom_usager = $value->getUsager()->getNom();
                    $prenom_usager = $value->getUsager()->getPrenom();
                    $nom_medecin = $value->getMedecin()->getNom();
                    $prenom_medecin = $value->getMedecin()->getPrenom();
                    $mois = $value->getMois3lettres();
                    $jour = $value->getNuméroJour();
                    $jour_semaine = $value->getJourSemaine();
                    echo "
                    <div class='card'>
                        <div class='col-2 text-right'>
                            <h1 class='display-4'><span class='badge badge-secondary'>$jour</span></h1>
                            <h2>$mois</h2>
                        </div>
                        <div class='col-10'>
                            <h3 class='text-uppercase'><strong>$nom_medecin $prenom_medecin</strong></h3>
                            <ul class='list-inline'>
                                <li class='list-inline-item'><i class='fa fa-calendar-o' aria-hidden='true'></i> $jour_semaine</li>
                                <li class='list-inline-item'><i class='fa fa-clock-o' aria-hidden='true'></i> $heure_debut - $heure_fin</li>
                            </ul>
                            <div>
                                <p>$nom_usager $prenom_usager</p>
                                <a href='#'>
                                    <img class='icone_modifier' src='img/icone_modifier.png' alt='icone modifier'/>".
                                "</a>
                                <a href='#' class='supprimerusagerBtn'  >
                                    <img class='icone_supprimer' src='img/icone_supprimer.png' alt='icone supprimer'/>".
                                " </a>
                            </div>
                        </div>
                    </div>";
                }
            ?>
            </div>
        </div>
    </body>

    <?php include 'footer.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', flecheHaut);
    </script>
</html>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Rdv</title>
        <link rel="stylesheet" href="css/CSSstats.css">
        <link rel="stylesheet" href="css/CSSheader.css">
        <link rel="stylesheet" href="css/CSSfooter.css">
        <link rel="icon" href="img/logo.png">
    </head>

    <?php include 'header.php'; ?>

    <body>
        <div class="body">
            <div class="usagers">
                <h1>Patients</h1>
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Femme</th>
                            <th>Homme</th>
                        </tr>
                    </thead>
                    <?php
                        require('../controleur/usager.controleur.php');
                        $controleur = new Usager_controleur();
                        $resultat = $controleur->liste_usagers();
                        $fj = 0;
                        $hj = 0;
                        $fa = 0;
                        $ha = 0;
                        $fv = 0;
                        $hv = 0;
                        foreach ($resultat as $value) {
                            if ($value->getCivilite() == "F") {
                                if ($value->getAge() < 25){
                                    $fj++;
                                }
                                elseif ($value->getAge() < 50){
                                    $fv++;
                                }
                                else{
                                    $fa++;
                                }
                            } else {
                                if ($value->getAge() < 25){
                                    $hj++;
                                }
                                elseif ($value->getAge() < 50){
                                    $hv++;
                                }
                                else{
                                    $ha++;
                                }
                            }
                        }
                    echo "
                    <tbody>
                        <tr>
                            <th>Moins de 25 ans</th>
                            <td id = 'fj'>$fj</td>
                            <td id = 'hj'>$hj</td>
                        </tr>   
                        <tr>
                            <th>Entre 25 et 50 ans</th>
                            <td id = 'fa'>$fa</td>
                            <td id = 'ha'>$ha</td>
                        </tr>
                        <tr>
                            <th>Plus de 50 ans</th>
                            <td id = 'fv'>$fv</td>
                            <td id = 'hv'>$hv</td>
                        </tr>
                    </tbody>";
                    ?>
                </table>
                <canvas id="camembertChart" width="800" height="200"></canvas>
            </div>
            <!--<div class="medecin">
                <h1>Médecins</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Médecin</th>
                            <th>Durée totale (heures)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            /*require('../controleur/medecin.controleur.php');
                            $controleur = new Medecin_controleur();
                            $resultat = $controleur->liste_medecins();
                            usort($resultat, function($a, $b) {
                                return strcmp($a->getNom(), $b->getNom());
                            });
                            foreach ($resultat as $value){
                                $prenom = $value->getPrenom();
                                $nom = $value->getNom();
                                $idMedecin = $value->getIdMedecin();
                                $nbHeures = 0;
                                //$nbHeures = $controleur->getNbHeures($idMedecin);
                                echo "
                                <tr>
                                    <td>$nom $prenom</td>
                                    <td>$nbHeures</td>
                                </tr>";
                            }*/
                        ?>
                    </tbody>
                </table>
            </div>-->
        </div>

    
    </body>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Données de répartition (à remplacer par vos données réelles)
        var data = {
            datasets: [{
                data: [<?php echo $hj?>, <?php echo $ha?>, <?php echo $hv?>, <?php echo $fv?>, <?php echo $fa?>, <?php echo $fj?>],
                backgroundColor: ["#00CED1", "#20B2AA", "#6A5ACD", "#FF6F61", "#FFA07A", "#FFD700"]
            }]
        };

        // Options du diagramme camembert
        var options = {
            responsive: false,
            maintainAspectRatio: false,
            hover: false
        };

        // Récupérer le contexte du canvas
        var ctx = document.getElementById('camembertChart').getContext('2d');

        // Créer le diagramme camembert
        var camembertChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: options
        });

        document.addEventListener('DOMContentLoaded', flecheHaut);
    </script>
</html>
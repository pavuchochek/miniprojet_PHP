<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Statistiques</title>
        <link rel="stylesheet" href="css/CSSheader.css">
        <link rel="stylesheet" href="css/CSSfooter.css">
        <link rel="stylesheet" href="css/CSSstats.css">
        <link rel="icon" href="img/logo.png">
    </head>

    <?php include 'header.php'; ?>

    <body>
        <div class="body">
            <div class="usagers">
                <div class="fixed">
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
                            require('/app/src/controleur/usager.controleur.php');
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
            </div>
            <div class="medecin">
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
                            require('/app/src/controleur/stats.controleur.php');
                            $controleur = new Stats_controleur();
                            $resultat = $controleur->liste_medecins();
                            $nbHeuresList = [];

                            foreach ($resultat as $value) {
                                $idMedecin = $value->getIdMedecin();
                                $nbHeuresList[$idMedecin] = $controleur->getNbHeuresPassee($idMedecin);
                            }

                            arsort($nbHeuresList);

                            foreach ($nbHeuresList as $idMedecin => $nbHeures) {
                                $medecin = $controleur->getMedecinById($idMedecin);
                                $prenom = $medecin->getPrenom();
                                $nom = $medecin->getNom();

                                echo "
                                <tr>
                                    <td>$nom $prenom</td>
                                    <td>$nbHeures</td>
                                </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    
    </body>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var data = {
            datasets: [{
                data: [<?php echo $hj?>, <?php echo $ha?>, <?php echo $hv?>, <?php echo $fv?>, <?php echo $fa?>, <?php echo $fj?>],
                backgroundColor: ["#00CED1", "#20B2AA", "#6A5ACD", "#FF6F61", "#FFA07A", "#FFD700"]
            }]
        };
        var options = {
            responsive: false,
            maintainAspectRatio: false,
            hover: false
        };
        var ctx = document.getElementById('camembertChart').getContext('2d');
        var camembertChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: options
        });

        document.addEventListener('DOMContentLoaded', flecheHaut);
    </script>
</html>
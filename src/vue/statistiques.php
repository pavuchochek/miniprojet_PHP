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
            <h1>Stats</h1>
            <div class="usagers">
                <h1>Usagers</h1>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Femme</th>
                                <th>Homme</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Moins de 25 ans</td>
                                <td>10</td>
                                <td>8</td>
                            </tr>   
                            <tr>
                                <td>Entre 25 et 50 ans</td>
                                <td>15</td>
                                <td>20</td>
                            </tr>
                            <tr>
                                <td>Plus de 50 ans</td>
                                <td>5</td>
                                <td>12</td>
                            </tr>
                        </tbody>
                    </table>
                    <canvas id="camembertChart" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="medecin">
                <table>
                    <thead>
                        <tr>
                            <th>Médecin</th>
                            <th>Durée totale (heures)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            require('../controleur/medecin.controleur.php');
                            $controleur = new Medecin_controleur();
                            $resultat = $controleur->liste_medecins();
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
        // Données de répartition (à remplacer par vos données réelles)
        var data = {
            labels: ["Femme", "Homme", "Autre", "Non renseigné", "Non binaire", "Transgenre"],
            datasets: [{
                data: [8, 15, 5, 3, 4, 19], // Remplacez ces valeurs par les vôtres
                backgroundColor: ["#FF6F61  ", "#FFD700  ", "#FFA07A  ", "#00CED1  ", "#6A5ACD  ", "#20B2AA  "],
                hoverBackgroundColor: ["#FF5733", "#FFEC38", "#FF8C69", "#33CCCC", "#836FFF", "#40E0D0"]
            }]
        };

        // Options du diagramme camembert
        var options = {
            responsive: false,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom',
                labels: {
                    fontColor: 'black',
                    fontSize: 14,
                    padding: 20,
                    boxWidth: 20
                }
            }
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
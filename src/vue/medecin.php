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
            <div class="partie_rdv">
                <h1>Liste des rdv</h1>
                <div class="box_rdv">
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        $heure = $i ."h00";
                        $date = $i ."/01/2020";
                        $usager = "Le monsieur au fond à droite";
                    ?>
                        <!-- affichage type d'un rdv (remplacer les # par l'action à faire)-->
                        <div class="rdv">
                            <div>
                                <h3><?php echo $date; ?> : <?php echo $heure; ?></h3>
                                <p>Usager: <?php echo $usager; ?></p>
                            </div>
                            <div class="boutons">
                                <a href='#'>
                                    <img class='icone_modifier' src='img/icone_modifier.png' alt='icone modifier'/>
                                </a>
                                <a href='#'>
                                    <img class='icone_supprimer' src='img/icone_supprimer.png' alt='icone supprimer'/>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="partie_usagers">
                <h1>Liste des usagers</h1>
                <!-- Faire l'affichage du même type que les médecins (parce que c'est bo)-->
            </div>
        </div>
    </body>
    
    <?php include 'footer.php'; ?>
</html>
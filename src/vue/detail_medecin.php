<?php clearstatcache();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Medecins</title>
        <link rel="stylesheet" href="css/CSSdetail_medecin.css">
        <link rel="stylesheet" href="css/CSSheader.css">
        <link rel="stylesheet" href="css/CSSfooter.css">
        <link rel="icon" href="img/logo.png">
    </head>

    <?php include 'header.php'; ?>

    <body>
        <h1 class="titre">Médecin :
            <?php
            require('../controleur/medecin.controleur.php');
            $controleur = new Medecin_controleur();
            $id = $_GET['id'];
            $prenom = $controleur->getMedecinById($id)->getPrenom();
            $nom = $controleur->getMedecinById($id)->getNom();
            echo $prenom . " " . $nom; ?>
        </h1>
        <div class="body">
            <div class="partie_rdv">
                <h1>Liste des rdv</h1>
                
                <div class="box_rdv">
                    <?php
                        $resultat = $controleur->getListeRdv($id);
                        if ($resultat == null) {
                            echo "<div>
                                <div>
                                    <h3>Aucun rdv</h3>
                                </div>
                            </div>";
                        } else {
                            foreach ($resultat as $value){
                                $heure = $value->getHeureDebut();
                                $date = $value->getDateRdv();
                                $usager = $value->getUsager()->getNom();
                                echo "<div class='rdv'>
                                    <div>
                                        <h3><?php echo $date; ?> : <?php echo $heure; ?></h3>
                                        <p>Usager: <?php echo $usager; ?></p>
                                    </div>
                                    <div class='boutons'>
                                        <a href='#'>
                                            <img class='icone_modifier' src='img/icone_modifier.png' alt='icone modifier'/>
                                        </a>
                                        <a href='#'>
                                            <img class='icone_supprimer' src='img/icone_supprimer.png' alt='icone supprimer'/>
                                        </a>
                                    </div>
                                </div>";
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="partie_usagers">
                <h1>Liste des usagers</h1>
            </div>
        </div>
    </body>
    
    <?php include 'footer.php'; ?>
</html>
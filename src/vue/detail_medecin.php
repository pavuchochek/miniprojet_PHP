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
                <div class="box_medecin" id="list_medecin">
                    <div>
                        <form action="" method="GET" class="recherche">
                            <input type="text" name="search" autocomplete="off" placeholder="Rechercher un médecin">
                            <input type="submit" value="Rechercher">
                        </form>
                    </div>
                    
                    <?php
                        $resultat = $controleur->getListeUsagersMedecin($id);
                        if (isset($_GET['search'])) {
                            $recherche = strtolower($_GET['search']);
                            $recherche = trim($recherche);
                            $resultat = $controleur->rechercherMedecins($recherche);
                        }
                        foreach ($resultat as $value){
                            $prenom = $value->getPrenom();
                            $nom = $value->getNom();
                            $idMedecin = $value->getIdMedecin();
                            $civilite= $value->getCivilite();
                            if ($value->getCivilite() === 'M') {
                                $genderIcon = 'icone_homme.png';
                            } else if ($value->getCivilite() === 'F'){
                                $genderIcon = 'icone_femme.png';
                            } else {
                                $genderIcon = 'icone_menu_usager.png';
                            }
                            echo "
                            <a href='detail_medecin.php?id=$idMedecin' class = 'lien_medecin'>
                                <div class='item_medecin'>
                                    <img class='icone_liste_medecin' src='img/$genderIcon' alt='icone d'un medecin'/>
                                    <div>
                                        <div class='nom'>"
                                            .$prenom . "<br>"
                                            .$nom.
                                        "</div>
                                        <div class='boutons'>
                                            <a href='modifier_medecin.php?prenom=$prenom&nom=$nom&id=$idMedecin&civilite=$civilite'>
                                                <img class='icone_modifier' src='img/icone_modifier.png' alt='icone modifier'/>
                                            </a>
                                            <a href='#' class='supprimerMedecinBtn' data-prenom='$prenom' data-nom='$nom' data-id='$idMedecin'>
                                                <img class='icone_supprimer' src='img/icone_supprimer.png' alt='icone supprimer'/>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </a>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
    
    <?php include 'footer.php'; ?>
</html>
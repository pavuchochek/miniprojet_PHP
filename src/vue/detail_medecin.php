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
                <div class = "titre2">
                    <h1>Liste des rdv</h1>

                    <div class="boutons_ajout boutons_ajout_rdv" id="afficherFormulaireRdv">
                        <input type="button" value="Ajouter un rdv" onclick="toggleForm()">
                    </div>
                </div>
                
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
                                $date = $value->getDateRdvString();
                                $nom_usager = $value->getUsager()->getNom();
                                $prenom_usager = $value->getUsager()->getPrenom();
                                echo "<div class='rdv'>
                                    <div>
                                        <div class='rdvinfo'>
                                            <h3>$date :</h3>
                                            <p>$heure</p>
                                        </div>
                                        <p>Usager: $nom_usager $prenom_usager</p>
                                    </div>
                                    <div class='boutonsrdv'>
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
                <div class = "titre2">
                    <h1>Liste des patients</h1>

                    <div class="boutons_ajout boutons_ajout_usager" id="afficherFormulaireUsager">
                        <input type="button" value="Assigner un usager" onclick="toggleForm()">
                    </div>
                </div>

                <div class="box_usagers" id="list_usagers">
                    <div>
                        <form action="" method="GET" class="recherche">
                            <input type="text" name="search" autocomplete="off" placeholder="Rechercher un patient">
                            <input type="submit" value="Rechercher">
                        </form>
                    </div>
                    
                    <?php
                        $resultat = $controleur->getListeUsagersMedecin($id);
                        if (isset($_GET['search'])) {
                            $recherche = strtolower($_GET['search']);
                            $recherche = trim($recherche);
                            $resultat = $controleur->rechercherUsager($recherche);
                        }
                        foreach ($resultat as $value){
                            $prenom = $value->getPrenom();
                            $nom = $value->getNom();
                            $civilite = $value->getCivilite();
                            $num = $value->getNsecuriteSociale();
                            if ($value->getCivilite() === 'M') {
                                $genderIcon = 'icone_homme_usager.png';
                            } else if ($value->getCivilite() === 'F'){
                                $genderIcon = 'icone_femme_usager.png';
                            } else {
                                $genderIcon = 'icone_menu_usager.png';
                            }
                            echo "
                            <a class='lien_medecin'>
                                <div class='item_usager'>
                                    <img class='icone_liste_usager' src='img/$genderIcon' alt='icone d'un medecin'/>
                                    <div>
                                        <div class='nom'><p>"
                                            .$prenom . "<br>"
                                            .$nom.
                                        "</p></div>
                                        <div class='boutonsusager'>
                                            <a href='modifier_usager.php?prenom=$prenom&nom=$nom&civilite=$civilite'>
                                                <img class='icone_modifier' src='img/icone_modifier.png' alt='icone modifier'/>
                                            </a>
                                            <a href='#' class='supprimerMedecinBtn' data-prenom='$prenom' data-nom='$nom'>
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
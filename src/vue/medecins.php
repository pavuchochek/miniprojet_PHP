<?php clearstatcache(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Medecins</title>
    <link rel="stylesheet" href="css/CSSmedecins.css">
    <link rel="stylesheet" href="css/CSSheader.css">
    <link rel="stylesheet" href="css/CSSfooter.css">
    <link rel="icon" href="img/logo.png">
</head>

<?php include 'header.php'; ?>

<body>
    <div class="body">

        <div id="formulaire" class="formulaire" style="display: none;">
            <form id="form" method="post" action="traitement_ajout_medecin.php" onsubmit="return Valide()">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" autocomplete="off">

                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" autocomplete="off">

                <label for="civilite">Civilité:</label>
                <select id="civilite" name="civilite">
                    <option value="M">Monsieur</option>
                    <option value="F">Madame</option>
                    <option value="A">Autre</option>
                </select>

                <input type="submit" id="bouton_valider" value="Ajouter">
            </form>
        </div>

            <div class="box_medecin" id="list_medecin">
                <div>
                    <form action="" method="GET" class="recherche">
                        <input type="text" name="search" autocomplete="off" placeholder="Rechercher un médecin">
                        <input type="submit" value="Rechercher">
                    </form>
                </div>
                
                <?php
                    require('../controleur/medecin.controleur.php');
                    $controleur = new Medecin_controleur();
                    $resultat=$controleur->liste_medecins();
                    if (isset($_GET['search'])) {
                        $recherche=strtolower($_GET['search']);
                        $recherche=trim($recherche);
                        $resultat=$controleur->rechercherMedecins($recherche);
                    }
                    foreach ($resultat as $value){
                        $prenom = $value->getPrenom();
                        $nom = $value->getNom();
                        $idMedecin = $value->getIdMedecin();
                        if ($value->getCivilite() === 'M') {
                            $genderIcon = 'icone_homme.png';
                        } else if ($value->getCivilite() === 'F'){
                            $genderIcon = 'icone_femme.png';
                        } else {
                            $genderIcon = 'icone_menu_usager.png';
                        }
                        echo "
                        <div class='item_medecin'>
                            <img class='icone_liste_medecin' src='img/$genderIcon' alt='icone d'un medecin'/>
                            <div>
                                <div class='nom'>"
                                    .$prenom . "<br>"
                                    .$nom.
                                "</div>
                                <div class='boutons'>
                                    <a href='modifier_medecin.php?prenom=$prenom & nom=$nom'>
                                        <img class='icone_modifier' src='img/icone_modifier.png' alt='icone modifier'/>
                                    </a>
                                    <a href='#' class='supprimerMedecinBtn' data-prenom='$prenom' data-nom='$nom'>
                                        <img class='icone_supprimer' src='img/icone_supprimer.png' alt='icone supprimer'/>
                                    </a>
                                </div>
                            </div>
                        </div>";
                    }
                ?>
            </div>

        <div class="boutons_modif" id="afficherFormulaire">
            <input type="button" value="Ajouter médecin" onclick="toggleForm()">
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        var formulaireVisible = false;

        function toggleForm() {
            var formulaire = document.getElementById('formulaire');
            var listMedecin = document.getElementById('list_medecin');

            if (formulaireVisible) {
                formulaire.style.display = 'none';
                listMedecin.style.display = 'block';
            } else {
                formulaire.style.display = 'block';
                listMedecin.style.display = 'none';
            }

            formulaireVisible = !formulaireVisible;
        }

        function Valide() {
            var prenom = document.getElementById('prenom').value;
            var nom = document.getElementById('nom').value;
            if (prenom === '' || nom === '') {
                return false;
            } else {
                return true;
            }
        }
    </script>
</body>
</html>

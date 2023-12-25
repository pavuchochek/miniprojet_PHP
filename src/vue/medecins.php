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

            <div id="formulaire" class="formulaire">
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
                    <script>
                        function Valide() {
                            var prenom = document.getElementById('prenom').value;
                            var nom = document.getElementById('nom').value;
                            if (prenom === '' || nom === '') {
                                return false;
                            } else {
                                return true;
                            }
                        }
                        document.getElementById('form').addEventListener('input', function () {
                            var prenom = document.getElementById('prenom').value;
                            var nom = document.getElementById('nom').value;
                            var bouton_valider = document.getElementById('bouton_valider');
                            if (prenom !== '' && nom !== '') {
                                bouton_valider.classList.add('active');
                            } else {
                                bouton_valider.classList.remove('active');
                            }
                        });
                    </script>
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
                                    .$value->getPrenom() . "<br>"
                                    .$value->getNom().
                                "</div>
                                <div class='boutons'>
                                    <a href='modifier_medecin.php?prenom=$prenom & nom=$nom'>
                                        <img class='icone_modifier' src='img/icone_modifier.png' alt='icone modifier'/>
                                    </a>
                                    <a href='#' id='supprimerMedecinBtn' data-prenom='<?php echo $prenom; ?>' data-nom='<?php echo $nom; ?>'>
                                        <img class='icone_supprimer' src='img/icone_supprimer.png' alt='icone supprimer'/>
                                    </a>
                                </div>
                            </div>
                        </div>";
                    }
                ?>
            </div>

            <div class="boutons_modif" id="afficherFormulaire">
                <input type="button">
            </div>

            <div class="popup" id="popupMedecin">
                <p>Voulez vous supprimer le médecin <?php echo $prenom." ". $nom; ?> ?</p>
                <div class="boutons_Popup">
                    <input type="button" value="Annuler" id="Bouton_popup_annuler">
                    <a href="supprimer_medecin.php?id=<?php echo $idMedecin ?>">
                        <input type="button" value="Oui">
                    </a>
                </div>
            </div>
        </div>
    </body>
    
    <?php include 'footer.php'; ?>

    <script>
        var list = document.getElementById('list_medecin');
        var boutonAfficher = document.getElementById('afficherFormulaire').getElementsByTagName('input')[0];
        document.getElementById('afficherFormulaire').addEventListener('click', function() {
            var formulaire = document.getElementById('formulaire');
            var list = document.getElementById('list_medecin');
            var boutonAfficher = document.getElementById('afficherFormulaire').getElementsByTagName('input')[0];
            if (formulaire.style.display == 'block') {
                formulaire.style.display = 'none';
                list.style.display = 'block';
            } else {
                formulaire.style.display = 'block';
                list.style.display = 'none';
            }
            if (boutonAfficher.value == 'Voir la liste des médecins') {
                boutonAfficher.value = 'Ajouter un médecin';
            } else
                boutonAfficher.value = 'Voir la liste des médecins';
        });
        document.addEventListener('DOMContentLoaded', flecheHaut);
        formulaire.style.display = 'none';
        list.style.display = 'block';
        boutonAfficher.value = 'Ajouter un médecin';

        var popup = document.getElementById('popupMedecin');
        popup.style.display = 'none';
        document.getElementById('supprimerMedecinBtn').addEventListener('click', function(event) {
            event.preventDefault();
            var prenom = this.getAttribute('data-prenom');
            var nom = this.getAttribute('data-nom');
            <?php $prenom = $prenom; ?>
            <?php $nom = $nom; ?>
            popup.style.display = 'block';
        
        });
        document.getElementById('Bouton_popup_annuler').addEventListener('click', function() {
            popup.style.display = 'none';
        });
    </script>
    
</html>
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
            <div id="formulaire" class="formulaire">
                <form id="medecinForm" method="post" action="traitements/traitement_ajout_medecin.php" onsubmit="return Valide()">
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
                    require('/app/src/controleur/medecin.controleur.php');
                    $controleur = new Medecin_controleur();
                    $resultat = $controleur->liste_medecins();
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
                        $class = '';
                        if ($value->getCivilite() === 'M') {
                            $genderIcon = 'icone_homme.png';
                        } else if ($value->getCivilite() === 'F'){
                            $genderIcon = 'icone_femme.png';
                        } else {
                            $genderIcon = 'icone_menu_usager.png';
                            $class = 'autre';
                        }
                        echo "
                        <a href='detail_medecin.php?id=$idMedecin' class = 'lien_medecin'>
                            <div class='item_medecin'>
                                <img class='icone_liste_medecin $class' src='img/$genderIcon' alt='icone d'un medecin'/>
                                <div>
                                    <div class='nom'>"
                                        .$prenom.
                                        "<br>"
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

            <div class="popup" id="popupMedecin">
                <p id="popupMedecinNom"> </p>
                <div class="boutons_Popup">
                    <input type="button" value="Annuler" id="Bouton_popup_annuler">
                    <a href='#'>
                        <input type='button' value='Oui'>
                    </a>
                </div>
            </div>

            <div class="boutons_modif" id="afficherFormulaire">
                <input id="boutonAfficher" type="button" value="Ajouter médecin" onclick="toggleForm()">
            </div>
        </div>

        <?php include 'footer.php'; ?>

        <script>
            //Script pour afficher ou cacher le formulaire d'ajout de médecin
            var formulaireVisible = false;
            function toggleForm() {
                var formulaire = document.getElementById('formulaire');
                var listMedecin = document.getElementById('list_medecin');
                var btn_modif = document.getElementById('boutonAfficher');
                var champ_formulaire1 = document.getElementById('prenom');
                var champ_formulaire2 = document.getElementById('nom');

                if (formulaireVisible) {
                    formulaire.style.display = 'none';
                    listMedecin.style.display = 'block';
                    btn_modif.value = 'Ajouter médecin';
                    formulaireVisible = false;
                    champ_formulaire1.value = '';
                    champ_formulaire2.value = '';
                } else {
                    formulaire.style.display = 'block';
                    listMedecin.style.display = 'none';
                    btn_modif.value = 'Annuler';
                    formulaireVisible = true;
                }
            }

            //Script pour vérifier la présence de valeur dans les champs de saisie du formulaire
            function Valide() {
                var prenom = document.getElementById('prenom').value;
                var nom = document.getElementById('nom').value;
                return prenom !== '' && nom !== '';
            }
            //Script pour activer le bouton valider du formulaire d'ajout de médecin
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('medecinForm').addEventListener('input', function () {
                    var prenom = document.getElementById('prenom').value;
                    var nom = document.getElementById('nom').value;
                    var submitBtn = document.getElementById('bouton_valider');
                    if (prenom !== '' && nom !== '') {
                        submitBtn.classList.add('active');
                    } else {
                        submitBtn.classList.remove('active');
                    }
                });
            });
            
            //Script de la popup de confirmation de suppression de médecin
            document.addEventListener('DOMContentLoaded', function() {
                var formulaireVisible = false;
                var popup = document.getElementById('popupMedecin');
                popup.style.display = 'none';

                var supprimerBtns = document.getElementsByClassName('supprimerMedecinBtn');
                //Script pour afficher la popup de confirmation de suppression de médecin
                for (var i = 0; i < supprimerBtns.length; i++) {
                    supprimerBtns[i].addEventListener('click', function(event) {
                        event.preventDefault();
                        var prenom = this.getAttribute('data-prenom');
                        var nom = this.getAttribute('data-nom');

                        var nomprenom = document.getElementById('popupMedecinNom');
                        nomprenom.innerHTML = "Voulez-vous supprimer le médecin " + prenom + ' ' + nom + " ?";
                        popup.style.display = 'block';
                        document.getElementById('Bouton_popup_annuler').setAttribute('data-prenom', prenom);
                        document.getElementById('Bouton_popup_annuler').setAttribute('data-nom', nom);
                        document.querySelector('#popupMedecin .boutons_Popup a').setAttribute('href', 'traitements/traitement_supprimer_medecin.php?id='+this.getAttribute('data-id'));
                    });
                }
                //Script pour initialiser la popup de confirmation de suppression de médecin
                document.getElementById('Bouton_popup_annuler').addEventListener('click', function() {
                    popup.style.display = 'none';
                    var prenom = this.getAttribute('data-prenom');
                    var nom = this.getAttribute('data-nom');
                });
            });
        </script>
    </body>
</html>

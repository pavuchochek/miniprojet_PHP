<?php clearstatcache(); ?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Medecins</title>
        <link rel="stylesheet" href="css/CSSusager.css">
        <link rel="stylesheet" href="css/CSSheader.css">
        <link rel="stylesheet" href="css/CSSfooter.css">
        <link rel="icon" href="img/logo.png">
    </head>

    <?php include 'header.php'; ?>

    <body>
        <div class="body">

            <div id="formulaire" class="formulaire" style="display: none;">
                <form id="usagerForm" method="post" action="traitement_ajout_usager.php" onsubmit="return Valide()">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" autocomplete="off">

                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" autocomplete="off">

                    <label for="civilite">Civilité :</label>
                    <select id="civilite" name="civilite">
                        <option value="M">Monsieur</option>
                        <option value="F">Madame</option>
                        <option value="A">Autre</option>
                    </select>
                    <label for="Adresse">Adresse :</label>
                    <input type="text" id="Adresse" name="Adresse" autocomplete="off">

                    <label for="dateNaissance">Date de naissance :</label>
                    <input type="date" id="dateNaissance" name="dateNaissance" autocomplete="off">

                    <label for="lieuNaissance">Lieu de naissance :</label>
                    <input type="text" id="lieuNaissance" name="lieuNaissance" autocomplete="off">

                    <label for="Numero_Secu">Numéro de sécurité sociale :</label>
                    <input type="text" id="Numero_Secu" name="Numero_Secu" autocomplete="off">

                    <label for="medecinReferent">Médecin référent:</label>
                    <select id="medecinReferent" name="medecinReferent">
                        <option value="null">Aucun</option>
                        <?php
                            require('/app/src/controleur/medecin.controleur.php');
                            $controleur = new Medecin_controleur();
                            $resultat = $controleur->liste_medecins();
                            foreach ($resultat as $value){
                                $prenom = $value->getPrenom();
                                $nom = $value->getNom();
                                $idMedecin = $value->getIdMedecin();
                                echo "<option value='$idMedecin'>$prenom $nom</option>";
                            }
                        ?>
                    </select>

                    <input type="submit" id="bouton_valider" value="Ajouter">
                </form>
            </div>

            <div class="box_medecin" id="list_medecin">
                <div>
                    <form action="" method="GET" class="recherche">
                        <input type="text" name="search" autocomplete="off" placeholder="Rechercher un patient">
                        <input type="submit" value="Rechercher">
                    </form>
                </div>
                
                <?php
                    require('app/src/controleur/usager.controleur.php');
                    $controleur = new Usager_Controleur();
                    $resultat = $controleur->liste_usagers();
                    foreach ($resultat as $value){
                        $prenom = $value->getPrenom();
                        $nom = $value->getNom();
                        $medecinRef = $value->getMedecinReferent();
                        if ($value->getCivilite() === 'M') {
                            $genderIcon = 'icone_homme_usager.png';
                        } else if ($value->getCivilite() === 'F'){
                            $genderIcon = 'icone_femme_usager.png';
                        } else {
                            $genderIcon = 'icone_autre.png';
                        }
                        if(is_null($medecinRef)){
                            $medecinRef = "∅";
                        }else{
                            $medecinRef=$medecinRef->getNom();
                        }
                        echo "
                            <a class='lien_medecin'>".
                            // ajouter le lien vers la page detail_usager quand la page sera faite
                                "<div class='item_usager'>
                                    <img class='icone_liste_usager' src='img/$genderIcon' alt='icone d'un medecin'/>
                                    <div>
                                        <div class='nom'><p>"
                                            .$prenom . "<br>"
                                            .$nom. "<br>Médecin : "
                                            .$medecinRef.
                                        "</p></div>
                                        <div class='boutonsusager'>
                                            <a href='modifier_usager.php?prenom=$prenom&nom=$nom'>
                                                <img class='icone_modifier' src='img/icone_modifier.png' alt='icone modifier'/>".
                                                // ajouter l'action modifier usager quand la page usager sera faite
                                            "</a>
                                            <a href='#' class='supprimerMedecinBtn' data-prenom='$prenom' data-nom='$nom'>
                                                <img class='icone_supprimer' src='img/icone_supprimer.png' alt='icone supprimer'/>".
                                                // ajouter l'action modifier usager quand la page usager sera faite
                                            " </a>
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
                    formulaireVisible = false;
                } else {
                    formulaire.style.display = 'block';
                    listMedecin.style.display = 'none';
                    formulaireVisible = true;
                }
            }

            function Valide() {
                var prenom = document.getElementById('prenom').value;
                var nom = document.getElementById('nom').value;
                return prenom !== '' && nom !== '';
            }
            
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('usagerForm').addEventListener('input', function () {
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
            
            
            document.addEventListener('DOMContentLoaded', function() {
                var formulaireVisible = false;
                var popup = document.getElementById('popupMedecin');
                popup.style.display = 'none';

                var supprimerBtns = document.getElementsByClassName('supprimerMedecinBtn');

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
                        document.querySelector('#popupMedecin .boutons_Popup a').setAttribute('href', 'traitement_supprimer_medecin.php?id='+this.getAttribute('data-id'));
                    });
                }

                document.getElementById('Bouton_popup_annuler').addEventListener('click', function() {
                    popup.style.display = 'none';
                    var prenom = this.getAttribute('data-prenom');
                    var nom = this.getAttribute('data-nom');
                });
            });
        </script>
    </body>
</html>

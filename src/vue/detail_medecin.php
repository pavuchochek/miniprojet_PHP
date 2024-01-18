<?php
    // Démarre la session
    session_start();

    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION['utilisateur_connecte'])) {
        // Redirige vers la page de connexion
        header("Location: login.php");
        exit(); // Assure que le script s'arrête après la redirection
    }
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

    <?php include '../includes/header.php'; ?>

    <body>
        <h1 class="titre">Médecin :
            <?php
            require('/app/src/controleur/medecin.controleur.php');
            $controleur = new Medecin_controleur();
            $idmedecin = $_GET['id'];
            $prenom = $controleur->getMedecinById($idmedecin)->getPrenom();
            $nom = $controleur->getMedecinById($idmedecin)->getNom();
            echo $prenom . " " . $nom; ?>
        </h1>
        <div class="body">
            <div class="partie_rdv">
                <div class = "titre2">
                    <h1>Liste des rendez-vous</h1>

                    <div class="boutons_ajout boutons_ajout_rdv" id="afficherFormulaireRdv">
                        <a href="rdv.php?idmedecin=<?php echo $idmedecin; ?>">
                            <input type="button" value="Ajouter un rendez-vous">
                        </a>
                    </div>
                </div>
                
                <div class="box_rdv">
                    <?php
                        $resultat = $controleur->getListeRdv($idmedecin);
                        if ($resultat == null) {
                            echo "<div>
                                <div>
                                    <h3>Aucun rdv</h3>
                                </div>
                            </div>";
                        } else {
                            foreach ($resultat as $value){
                                $heure = $value->getHeureDebut();
                                $heure = substr($heure, 0, -3);
                                $date = $value->getDateRdvString();
                                $nom_usager = $value->getUsager()->getNom();
                                $prenom_usager = $value->getUsager()->getPrenom();
                                $id_usager = $value->getUsager()->getIdUsager();
                                $heure_fin = $value->getHeureFin();
                                $heure_debut = $value->getHeureDebut();
                                $date_rdv = $value->getDateRdv();
                                echo "
                                <div class='rdv'>
                                    <div>
                                        <div class='rdvinfo'>
                                            <h3>$date :</h3>
                                            <p>$heure</p>
                                        </div>
                                        <p>Patient : $nom_usager $prenom_usager</p>
                                    </div>
                                    <div class='boutonsrdv'>
                                        <a href='modifier_rdv.php?usager=$id_usager&medecin=$idmedecin&date=$date_rdv&heure_debut=$heure_debut&heure_fin=$heure_fin'>
                                            <img class='icone_modifier' src='img/icone_modifier.png' alt='icone modifier'/>".
                                        "</a>
                                        <a href='#' class='supprimerRdvBtn' data-usager='$id_usager' data-medecin='$idmedecin' data-date='$date_rdv' data-heure-debut='$heure_debut' data-heure-fin='$heure_fin'>
                                            <img class='icone_supprimer' src='img/icone_supprimer.png' alt='icone supprimer'/>".
                                        " </a>
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
                    <form method="post" action="traitements/traitement_assigner_usager.php" id="form_usager">
                        <input type="hidden" name="medecinReferent" value="<?php echo $idmedecin; ?>">
                        <select name="idUsager" id="combo_box">
                            <?php
                            $resultat = $controleur->getListeUsagersMedecin($idmedecin);
                            $usagers = $controleur->listeUsagersNonReferents($idmedecin);
                            if ($usagers == null) {
                                echo "<option value=''>Aucun patient</option>";
                            } else {
                                foreach ($usagers as $value) {
                                    $prenom = $value->getPrenom();
                                    $nom = $value->getNom();
                                    $id = $value->getIdUsager();
                                    $num = $value->getNsecuriteSociale();
                                    echo "<option value='$id'>$prenom $nom ($num)</option>";
                                }
                            }
                            ?>
                        </select>
                        <div class="bouton_assigner">
                            <input type="submit" value="Assigner un usager" class="boutons_ajout boutons_ajout_usager" id="assignerUsager">
                        </div>
                    </form>

                    <div class="boutons_ajout boutons_ajout_usager" onclick="afficherComboBox()">
                        <input type="button" id="afficherFormulaireUsager">
                    </div>

                </div>

                <div class="box_usagers" id="list_usagers">
                    
                    <?php
                        
                        if ($resultat == null) {
                            echo "<div class='item_usager vide'>
                                <div>
                                    <h3>Aucun patient</h3>
                                </div>
                            </div>";
                        } else {
                            foreach ($resultat as $value){
                                $prenom = $value->getPrenom();
                                $nom = $value->getNom();
                                $id = $value->getIdUsager();
                                $num = $value->getNsecuriteSociale();
                                if ($value->getCivilite() === 'M') {
                                    $genderIcon = 'icone_homme_usager.png';
                                } else if ($value->getCivilite() === 'F'){
                                    $genderIcon = 'icone_femme_usager.png';
                                } else {
                                    $genderIcon = 'icone_autre.png';
                                }
                                echo "
                                <a class='lien_usager'>".
                                // ajouter le lien vers la page detail_usager quand la page sera faite
                                    "<div class='item_usager'>
                                        <img class='icone_liste_usager' src='img/$genderIcon' alt='icone d'un usager'/>
                                        <div>
                                            <div class='nom'><p>"
                                                .$prenom . "<br>"
                                                .$nom.
                                            "</p></div>
                                            <div class='boutonsusager'>
                                                <a href='modifier_usager.php?id=$id'>
                                                    <img class='icone_modifier' src='img/icone_modifier.png' alt='icone modifier'/>".
                                                "</a>
                                                <a href='#' class='supprimerusagerBtn' data-prenom='$prenom' data-nom='$nom' data-id='$id' data-idMedecin='$idmedecin'>
                                                    <img class='icone_supprimer' src='img/icone_supprimer.png' alt='icone supprimer'/>".
                                                " </a>
                                            </div>
                                        </div>
                                    </div>
                                </a>";
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="popup" id="popupusager">
                <p id="popupusagerNom"> </p>
                <div class="boutons_Popup">
                    <input type="button" value="Annuler" id="Bouton_popup_annuler">
                    <a href='#' id = 'suppr'>
                        <input type='button' value='Supprimer'>
                    </a>
                    <a href='#' id = 'enleveMed'>
                        <input type='button' value='Enlever médecin'>
                    </a>
                </div>
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
        </div>
    </body>
    
    <?php include '../includes/footer.php'; ?>

    <script>
        var form_usager = document.getElementById('form_usager');
        form_usager.style.display = 'none';
        document.getElementById('afficherFormulaireUsager').value = 'Assigner un usager';
        function afficherComboBox() {
            var form_usager = document.getElementById('form_usager');
            if (form_usager.style.display === 'none') {
                form_usager.style.display = 'block';
                document.getElementById('afficherFormulaireUsager').value = 'Cacher la sélection';
            } else {
                form_usager.style.display = 'none';
                document.getElementById('afficherFormulaireUsager').value = 'Assigner un usager';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var popup = document.getElementById('popupusager');
            popup.style.display = 'none';

            var supprimerBtns = document.getElementsByClassName('supprimerusagerBtn');

            for (var i = 0; i < supprimerBtns.length; i++) {
                supprimerBtns[i].addEventListener('click', function(event) {
                    event.preventDefault();
                    var prenom = this.getAttribute('data-prenom');
                    var nom = this.getAttribute('data-nom');

                    var nomprenom = document.getElementById('popupusagerNom');
                    nomprenom.innerHTML = "Voulez-vous supprimer le patient " + prenom + ' ' + nom + " <br>ou lui enlever le médecin référent?";
                    popup.style.display = 'block';
                    document.getElementById('Bouton_popup_annuler').setAttribute('data-prenom', prenom);
                    document.getElementById('Bouton_popup_annuler').setAttribute('data-nom', nom);
                    document.querySelector('#popupusager .boutons_Popup a#suppr').setAttribute('href', 'traitements/traitement_supprimer_usager.php?id='+this.getAttribute('data-id'));
                    document.querySelector('#popupusager .boutons_Popup a#enleveMed').setAttribute('href', 'traitements/traitement_enlever_medecin_usager.php?id='+this.getAttribute('data-id')+'&idMedecin='+this.getAttribute('data-idMedecin'));
                });
            }

            document.getElementById('Bouton_popup_annuler').addEventListener('click', function() {
                popup.style.display = 'none';
                var prenom = this.getAttribute('data-prenom');
                var nom = this.getAttribute('data-nom');
            });
            
        });
        document.addEventListener('DOMContentLoaded', function() {
            var formulaireVisible = false;
            var popup = document.getElementById('popupMedecin');
            popup.style.display = 'none';

            var supprimerBtns = document.getElementsByClassName('supprimerRdvBtn');
            for (var i = 0; i < supprimerBtns.length; i++) {
                supprimerBtns[i].addEventListener('click', function(event) {
                    event.preventDefault();
                    var idUsager = this.getAttribute('data-usager');
                    var idMedecin = this.getAttribute('data-medecin');
                    var date = this.getAttribute('data-date');
                    var heureDebut = this.getAttribute('data-heure-debut');
                    var heureFin = this.getAttribute('data-heure-fin');

                    var nomprenom = document.getElementById('popupMedecinNom');
                    nomprenom.innerHTML = "Voulez-vous supprimer le rendez-vous du " + date + ' de ' + heureDebut + ' à ' + heureFin + " ?";
                    popup.style.display = 'block';
                    document.querySelector('#popupMedecin .boutons_Popup a').setAttribute('href', 'traitements/traitement_supprimer_rdv.php?idusager='+this.getAttribute('data-usager')+'&idmedecin='+this.getAttribute('data-medecin')+'&date='+this.getAttribute('data-date')+'&heureDebut='+this.getAttribute('data-heure-debut')+'&heureFin='+this.getAttribute('data-heure-fin'));
                });
            }
            document.getElementById('Bouton_popup_annuler').addEventListener('click', function() {
                popup.style.display = 'none';
                var prenom = this.getAttribute('data-prenom');
                var nom = this.getAttribute('data-nom');
            });
        });
    </script>
</html>
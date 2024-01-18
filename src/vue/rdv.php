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
        <title>Rendez-vous - Cabinet Médical</title>
        <link rel="stylesheet" href="css/CSSrdv.css">
        <link rel="stylesheet" href="css/CSSheader.css">
        <link rel="stylesheet" href="css/CSSfooter.css">
        <link rel="icon" href="img/logo.png">
    </head>

    <?php include '../includes/header.php'; ?>

    <body>
        <div class="body">
            <div id="formulaire" class="formulaire">
                <form id="rdvForm" method="post" action="traitements/traitement_ajout_rdv.php" onsubmit="return Valide()">
                    
                    <label for="usager">Patient :</label>
                    <select id="usager" name="usager" onchange="updateMedecin()" required>

                        <option value="" selected disabled>Choisir un patient</option>
                        <?php
                            require('/app/src/controleur/rdv.controleur.php');
                            $controleur = new Rdv_controleur();
                            $resultat = $controleur->liste_usager();
                            foreach ($resultat as $value){
                                $nom = $value->getNom();
                                $prenom = $value->getPrenom();
                                $id = $value->getIdUsager();
                                $medecinReferent = $value->getMedecinReferent() !== null ? $value->getMedecinReferent()->getIdMedecin() : null;
                                echo "<option value='$id' data-medecin-referent='$medecinReferent'>$nom $prenom</option>";
                            }                            
                        ?>
                    </select>

                    <label for="medecin">Médecin :</label>
                    <select id="medecin" name="medecin" required>
                        <option value="" selected disabled>Choisir un médecin</option>
                        <?php
                            $resultat = $controleur->liste_medecins();
                            foreach ($resultat as $value){
                                $nom = $value->getNom();
                                $prenom = $value->getPrenom();
                                $id = $value->getIdMedecin();
                                echo "<option value='$id'>$nom $prenom</option>";
                            }
                        ?>
                    </select>

                    <label for="date">Date :</label>
                    <input type="date" id="date" name="date" required>

                    <label for="heure_debut">Heure de début :</label>
                    <input type="time" id="heure_debut" name="heure_debut" required>

                    <label for="heure_fin">Heure de fin :</label>
                    <input type="time" id="heure_fin" name="heure_fin" required>

                    <input type="submit" id="bouton_valider" value="Ajouter">
                </form>
            </div>

            <div class="boutons_modif" id="afficherFormulaire">
                <input id="boutonAfficher" type="button" value="Ajouter un rendez-vous" onclick="toggleForm()">
            </div>

            <form action="" method="GET" class="recherche" id="recherche">
                <select name="usagerFilter">
                    <option value="">Tous les patients</option>
                    <?php
                        $resultat = $controleur->liste_usager_avec_rdv();
                        foreach ($resultat as $value){
                            $nom = $value->getNom();
                            $prenom = $value->getPrenom();
                            $id = $value->getIdUsager();
                            echo "<option value='$id'>$nom $prenom</option>";
                        }
                    ?>
                </select>

                <select name="medecinFilter">
                    <option value="">Tous les médecins</option>
                    <?php
                        $resultat = $controleur->liste_medecin_avec_rdv();
                        foreach ($resultat as $value){
                            $nom = $value->getNom();
                            $prenom = $value->getPrenom();
                            $id = $value->getIdMedecin();
                            echo "<option value='$id'>$nom $prenom</option>";
                        }
                    ?>
                </select>

                <input type="submit" value="Rechercher">
            </form>
            <div class="card-container" id="list_rdv">

                <?php
                    $resultat = $controleur->liste_rdv();

                    if (isset ($_GET['usagerFilter']) && isset($_GET['medecinFilter'])) {
                        if ($_GET['medecinFilter'] !== "") {
                            $id = intval($_GET['medecinFilter']);
                            if ($_GET['usagerFilter'] !== "") {
                                $id2 = intval($_GET['usagerFilter']);
                                $resultat = $controleur->getRdvByIdMedecinIdUsager($id2, $id);
                            } else {
                                $resultat = $controleur->getRdvByIdMedecin($id);
                            }
                        } else if ($_GET['usagerFilter'] !== ""){
                            $id = intval($_GET['usagerFilter']);
                            $resultat = $controleur->getRdvByIdUsager($id);
                        }
                    }

                    foreach ($resultat as $value){
                        $date_rdv = $value->getDateRdv();
                        $date = $value->getDateRdvString();
                        $heure_debut = $value->getHeureDebut();
                        $heure_debut = substr($heure_debut, 0, -3);
                        $heure_fin = $value->getHeureFin();
                        $heure_fin = substr($heure_fin, 0, -3);
                        $nom_usager = $value->getUsager()->getNom();
                        $prenom_usager = $value->getUsager()->getPrenom();
                        $id_usager = $value->getUsager()->getIdUsager();
                        $nom_medecin = $value->getMedecin()->getNom();
                        $prenom_medecin = $value->getMedecin()->getPrenom();
                        $id_medecin = $value->getMedecin()->getIdMedecin();
                        $mois = $value->getMois3lettres();
                        $jour = $value->getNuméroJour();
                        $jour_semaine = $value->getJourSemaine();
                        $annee = $value->getAnnee();

                        echo "
                        <div class='card'>
                            <div class='col-2 text-right'>
                                <h2 class='display-4'>$jour $mois $annee</h2>
                            </div>
                            <div class='col-10'>
                                <ul class='list-inline'>
                                    <li class='list-inline-item'><i class='fa fa-calendar-o' aria-hidden='true'></i> $jour_semaine</li>
                                    <li class='list-inline-item'><i class='fa fa-clock-o' aria-hidden='true'></i> $heure_debut - $heure_fin</li>
                                </ul>
                                <h3 class='text-uppercase'><strong>Médecin : $nom_medecin $prenom_medecin</strong></h3>
                                <div>
                                    <p>Patient : $nom_usager $prenom_usager</p>
                                    <div class='boutons'>
                                        <a href='modifier_rdv.php?usager=$id_usager&medecin=$id_medecin&date=$date_rdv&heure_debut=$heure_debut&heure_fin=$heure_fin'>
                                            <img class='icone_modifier' src='img/icone_modifier.png' alt='icone modifier'/>".
                                        "</a>
                                        <a href='#' class='supprimerRdvBtn' data-usager='$id_usager' data-medecin='$id_medecin' data-date='$date_rdv' data-heure-debut='$heure_debut' data-heure-fin='$heure_fin'>
                                            <img class='icone_supprimer' src='img/icone_supprimer.png' alt='icone supprimer'/>".
                                        " </a>
                                    </div>
                                </div>
                            </div>
                        </div>";
                    }
                ?>
            </div>

            <div class="popup" id="popupRdv">
                <p id="popupRdvNom"> </p>
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
        
        var formulaireVisible = false;

        <?php
            if (isset($_GET['idmedecin']) or isset($_GET['idusager'])) {
                echo 'toggleForm();';
                if (isset($_GET['idmedecin'])) {
                    echo 'document.getElementById("medecin").value = '.$_GET['idmedecin'].';';
                }
                if (isset($_GET['idusager'])) {
                    echo 'document.getElementById("usager").value = '.$_GET['idusager'].';';
                }
            }
        ?>

        function toggleForm() {
            var formulaire = document.getElementById('formulaire');
            var listMedecin = document.getElementById('list_rdv');
            var recherche = document.getElementById('recherche');
            var btn_modif = document.getElementById('boutonAfficher');
            var champ_formulaire_1 = document.getElementById('usager');
            var champ_formulaire_2 = document.getElementById('medecin');
            var champ_formulaire_3 = document.getElementById('date');
            var champ_formulaire_4 = document.getElementById('heure_debut');
            var champ_formulaire_5 = document.getElementById('heure_fin');

            if (formulaireVisible) {
                formulaire.style.display = 'none';
                listMedecin.style.display = 'flex';
                recherche.style.display = 'flex';
                btn_modif.value = 'Ajouter un rendez-vous';
                formulaireVisible = false;
                champ_formulaire_1.value = '';
                champ_formulaire_2.value = '';
                champ_formulaire_3.value = '';
                champ_formulaire_4.value = '';
                champ_formulaire_5.value = '';
            } else {
                formulaire.style.display = 'block';
                listMedecin.style.display = 'none';
                recherche.style.display = 'none';
                btn_modif.value = 'Annuler';
                formulaireVisible = true;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var formulaireVisible = false;
            var popup = document.getElementById('popupRdv');
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

                    var nomprenom = document.getElementById('popupRdvNom');
                    nomprenom.innerHTML = "Voulez-vous supprimer le rendez-vous du " + date + ' de ' + heureDebut + ' à ' + heureFin + " ?";
                    popup.style.display = 'block';
                    document.querySelector('#popupRdv .boutons_Popup a').setAttribute('href', 'traitements/traitement_supprimer_rdv.php?idusager='+this.getAttribute('data-usager')+'&idmedecin='+this.getAttribute('data-medecin')+'&date='+this.getAttribute('data-date')+'&heureDebut='+this.getAttribute('data-heure-debut')+'&heureFin='+this.getAttribute('data-heure-fin'));
                });
            }

            document.getElementById('Bouton_popup_annuler').addEventListener('click', function() {
                popup.style.display = 'none';
                var prenom = this.getAttribute('data-prenom');
                var nom = this.getAttribute('data-nom');
            });
        });

        function updateMedecin() {
            var medecinSelect = document.getElementById("medecin");
            var usagerSelect = document.getElementById("usager");
            var idUsager = usagerSelect.value;
            var idMedecinReferent = usagerSelect.options[usagerSelect.selectedIndex].getAttribute('data-medecin-referent');
            medecinSelect.value = idMedecinReferent;
        }

        document.addEventListener('DOMContentLoaded', flecheHaut);
    </script>
</html>
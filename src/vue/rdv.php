<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Rendez-vous</title>
        <link rel="stylesheet" href="css/CSSrdv.css">
        <link rel="stylesheet" href="css/CSSheader.css">
        <link rel="stylesheet" href="css/CSSfooter.css">
        <link rel="icon" href="img/logo.png">
    </head>

    <?php include 'header.php'; ?>

    <body>
        <div class="body">
            <div id="formulaire" class="formulaire">
                <form id="rdvForm" method="post" action="traitements/traitement_ajout_rdv.php" onsubmit="return Valide()">
                    <label for="usager">Patient :</label>
                    <select id="usager" name="usager">
                        <option value="" selected disabled hidden>Choisir un patient</option>
                        <?php
                            require('/app/src/controleur/rdv.controleur.php');
                            $controleur = new Rdv_controleur();
                            $resultat = $controleur->liste_usager();
                            foreach ($resultat as $value){
                                $nom = $value->getNom();
                                $prenom = $value->getPrenom();
                                $id = $value->getIdUsager();
                                echo "<option value='$id'>$nom $prenom</option>";
                            }
                        ?>
                    </select>

                    <label for="medecin">Médecin :</label>
                    <select id="medecin" name="medecin">
                        <option value="" selected disabled hidden>Choisir un médecin</option>
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
                    <option value="">Tous les usagers</option>
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
                                        <a href='#'>
                                            <img class='icone_modifier' src='img/icone_modifier.png' alt='icone modifier'/>".
                                        "</a>
                                        <a href='#' class='supprimerRdvBtn'  >
                                            <img class='icone_supprimer' src='img/icone_supprimer.png' alt='icone supprimer'/>".
                                        " </a>
                                    </div>
                                </div>
                            </div>
                        </div>";
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

        </div>
        
    </body>

    <?php include 'footer.php'; ?>
    <script>
        //Script pour afficher ou cacher le formulaire d'ajout de médecin
        var formulaireVisible = false;
        function toggleForm() {
            var formulaire = document.getElementById('formulaire');
            var listMedecin = document.getElementById('list_rdv');
            var recherche = document.getElementById('recherche');
            var btn_modif = document.getElementById('boutonAfficher');

            if (formulaireVisible) {
                formulaire.style.display = 'none';
                listMedecin.style.display = 'flex';
                recherche.style.display = 'flex';
                btn_modif.value = 'Ajouter un rendez-vous';
                formulaireVisible = false;
            } else {
                formulaire.style.display = 'block';
                listMedecin.style.display = 'none';
                recherche.style.display = 'none';
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
            document.getElementById('rdvForm').addEventListener('input', function () {
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

            var supprimerBtns = document.getElementsByClassName('supprimerRdvBtn');
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

        document.addEventListener('DOMContentLoaded', flecheHaut);
    </script>
</html>
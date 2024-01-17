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
            <div class="boutons_modif" >
                <input type="button" value="Ajouter un rendez-vous">
            </div>
            <form action="" method="GET" class="recherche">
                <select name="usagerFilter">
                    <option value="">Tous les usagers</option>
                    <?php
                        require('/app/src/controleur/rdv.controleur.php');
                        $controleur = new Rdv_controleur();
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
                        $nom_medecin = $value->getMedecin()->getNom();
                        $prenom_medecin = $value->getMedecin()->getPrenom();
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
                                        <a href='#' class='supprimerusagerBtn'  >
                                            <img class='icone_supprimer' src='img/icone_supprimer.png' alt='icone supprimer'/>".
                                        " </a>
                                    </div>
                                </div>
                            </div>
                        </div>";
                    }
                ?>
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
            var btn_modif = document.getElementById('boutonAfficher');

            if (formulaireVisible) {
                formulaire.style.display = 'none';
                listMedecin.style.display = 'block';
                btn_modif.value = 'Ajouter médecin';
                formulaireVisible = false;
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

        document.addEventListener('DOMContentLoaded', flecheHaut);
    </script>
</html>
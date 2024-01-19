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
        <title>Usager - Cabinet Médical</title>
        <link rel="stylesheet" href="css/CSSdetail_usager.css">
        <link rel="stylesheet" href="css/CSSheader.css">
        <link rel="stylesheet" href="css/CSSfooter.css">
        <link rel="icon" href="img/logo.png">
    </head>

    <?php include '../includes/header.php'; ?>

    <body>
        <h1 class="titre">Usager :
            <?php
            require('/app/src/controleur/usager.controleur.php');
            $controleur = new Usager_controleur();
            $idusager = $_GET['id'];
            $prenom = $controleur->getusagerById($idusager)->getPrenom();
            $nom = $controleur->getusagerById($idusager)->getNom();
            echo $prenom . " " . $nom; ?>
        </h1>
        <div class="body">
            <div class="partie_rdv">
                <div class = "titre2">
                    <h1>Liste des rendez-vous</h1>

                    <div class="boutons_ajout boutons_ajout_rdv" id="afficherFormulaireRdv">
                        <a href="rdv.php?idusager=<?php echo $idusager; ?>">
                            <input type="button" value="Ajouter un rendez-vous">
                        </a>
                    </div>
                </div>
                
                <div class="box_rdv">
                    <?php
                        $resultat = $controleur->getListeRdv($idusager);
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
                                        <a href='modifier_rdv.php?usager=$id_usager&usager=$idusager&date=$date_rdv&heure_debut=$heure_debut&heure_fin=$heure_fin'>
                                            <img class='icone_modifier' src='img/icone_modifier.png' alt='icone modifier'/>".
                                        "</a>
                                        <a href='#' class='supprimerRdvBtn' data-usager='$id_usager' data-usager='$idusager' data-date='$date_rdv' data-heure-debut='$heure_debut' data-heure-fin='$heure_fin'>
                                            <img class='icone_supprimer' src='img/icone_supprimer.png' alt='icone supprimer'/>".
                                        " </a>
                                    </div>
                                </div>";
                            }
                        }
                    ?>
                </div>
            </div>
           
            <div class="popup" id="popupRdv">
                <p id="popupRdvNom"> </p>
                <div class="boutons_Popup">
                    <input type="button" value="Annuler" id="Bouton_popup_annuler_rdv">
                    <a href='#'>
                        <input type='button' value='Oui'>
                    </a>
                </div>
            </div>
        </div>
    </body>
    
    <?php include '../includes/footer.php'; ?>

    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            var formulaireVisible = false;
            var popupRdv = document.getElementById('popupRdv');
            popupRdv.style.display = 'none';

            var supprimerBtns = document.getElementsByClassName('supprimerRdvBtn');
            for (var i = 0; i < supprimerBtns.length; i++) {
                supprimerBtns[i].addEventListener('click', function(event) {
                    event.preventDefault();
                    var idUsager = this.getAttribute('data-usager');
                    var idusager = this.getAttribute('data-usager');
                    var date = this.getAttribute('data-date');
                    var heureDebut = this.getAttribute('data-heure-debut');
                    var heureFin = this.getAttribute('data-heure-fin');

                    var nomprenom = document.getElementById('popupRdvNom');
                    nomprenom.innerHTML = "Voulez-vous supprimer le rendez-vous du " + date + ' de ' + heureDebut + ' à ' + heureFin + " ?";
                    popupRdv.style.display = 'block';
                    document.querySelector('#popupRdv .boutons_Popup a').setAttribute('href', 'traitements/traitement_supprimer_rdv.php?idusager='+this.getAttribute('data-usager')+'&idusager='+this.getAttribute('data-usager')+'&date='+this.getAttribute('data-date')+'&heureDebut='+this.getAttribute('data-heure-debut')+'&heureFin='+this.getAttribute('data-heure-fin'));
                });
            }
            document.getElementById('Bouton_popup_annuler_rdv').addEventListener('click', function() {
                popupRdv.style.display = 'none';
            });
        });
    </script>
</html>
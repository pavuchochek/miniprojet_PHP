<?php clearstatcache();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Patients</title>
        <link rel="stylesheet" href="css/CSSusager.css">
        <link rel="stylesheet" href="css/CSSheader.css">
        <link rel="stylesheet" href="css/CSSfooter.css">
        <link rel="icon" href="img/logo.png">
    </head>

    <?php include 'header.php'; ?>

    <body>
        <div class="body">

            <div id="formulaire" class="formulaire" style="display: block;">
                <form id="usagerForm" method="post" action="traitements/traitement_modifier_usager.php" onsubmit="return Valide()">
                <?php
                    $idUsager = $_GET['id'];
                    require('/app/src/controleur/usager.controleur.php');
                    $controleur = new Usager_controleur();
                    $resultat = $controleur->getUsagerById($idUsager);
                    $prenom = $resultat->getPrenom();
                    $nom = $resultat->getNom();
                    $civilite = $resultat->getCivilite();
                    $adresse = $resultat->getAdresse();
                    $dateNaissance = $resultat->getDateNaissance();
                    $lieuNaissance = $resultat->getLieuNaissance();
                    $numeroSecu = $resultat->getNsecuriteSociale();
                    $medecinReferent = $resultat->getMedecinReferent()->getIdMedecin();
                ?>

                    <input type="hidden" name="idUsager" value="<?php echo $idUsager; ?>">

                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" autocomplete="off" value="<?php echo $prenom; ?>">

                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" autocomplete="off" value="<?php echo $nom; ?>">

                    <label for="civilite">Civilité :</label>
                    <select id="civilite" name="civilite">
                        <?php if($civilite=='M'){ ?>
                            <option value="M" selected>Monsieur</option>
                            <option value="F">Madame</option>
                            <option value="A">Autre</option>
                        <?php }else if($civilite=='F'){ ?>
                            <option value="M">Monsieur</option>
                            <option value="F" selected>Madame</option>
                            <option value="A">Autre</option>
                        <?php }else{ ?>
                            <option value="M">Monsieur</option>
                            <option value="F">Madame</option>
                            <option value="A" selected>Autre</option>
                        <?php } ?>
                    </select>

                    <label for="Adresse">Adresse :</label>
                    <input type="text" id="Adresse" name="Adresse" autocomplete="off" value="<?php echo $adresse; ?>">

                    <label for="dateNaissance">Date de naissance :</label>
                    <input type="date" id="dateNaissance" name="dateNaissance" autocomplete="off" value="<?php echo $dateNaissance; ?>">

                    <label for="lieuNaissance">Lieu de naissance :</label>
                    <input type="text" id="lieuNaissance" name="lieuNaissance" autocomplete="off" value="<?php echo $lieuNaissance; ?>">

                    <label for="Numero_Secu">Numéro de sécurité sociale :</label>
                    <input type="text" id="Numero_Secu" name="Numero_Secu" autocomplete="off" value="<?php echo $numeroSecu; ?>">

                    <label for="medecinReferent">Médecin référent:</label>
                    <select id="medecinReferent" name="medecinReferent">
                        <option value="null">Aucun</option>
                        <?php
                            $resultat = $controleur->liste_medecins();
                            foreach ($resultat as $value){
                                $prenom = $value->getPrenom();
                                $nom = $value->getNom();
                                $idMedecin = $value->getId();
                                if ($idMedecin == $medecinReferent) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                                echo "<option value='$idMedecin' $selected>$prenom $nom</option>";
                            }
                        ?>
                    </select>

                    <input type="submit" id="bouton_valider" value="Ajouter">

                    <script>
                        function Valide() {
                            var prenom = document.getElementById('prenom').value;
                            var nom = document.getElementById('nom').value;
                            var adresse = document.getElementById('Adresse').value;
                            var lieuNaissance = document.getElementById('lieuNaissance').value;
                            var Numero_Secu = document.getElementById('Numero_Secu').value;
                            var dateNaissance = document.getElementById('dateNaissance').value;
                            Numero_Secu = parseInt(Numero_Secu);

                            if (Numero_Secu.toString().length === 13 && !isNaN(Numero_Secu)) {
                                Numero_Secu = Number(Numero_Secu);
                            } else {
                                Numero_Secu = '';
                            }
                            return prenom !== '' && nom !== '' && adresse !== '' && lieuNaissance !== '' && Numero_Secu !== '' && dateNaissance !== '';
                        }
                        
                        
                        document.addEventListener('DOMContentLoaded', function() {
                            document.getElementById('usagerForm').addEventListener('input', function () {
                                var prenom = document.getElementById('prenom').value;
                                var nom = document.getElementById('nom').value;
                                var adresse = document.getElementById('Adresse').value;
                                var lieuNaissance = document.getElementById('lieuNaissance').value;
                                var Numero_Secu = document.getElementById('Numero_Secu').value;
                                var dateNaissance = document.getElementById('dateNaissance').value;
                                Numero_Secu = parseInt(Numero_Secu);

                                if (Numero_Secu.toString().length === 13 && !isNaN(Numero_Secu)) {
                                    Numero_Secu = Number(Numero_Secu);
                                } else {
                                    Numero_Secu = '';
                                }
                                var submitBtn = document.getElementById('bouton_valider');
                                if (prenom !== '' && nom !== '' && adresse !== '' && lieuNaissance !== '' && Numero_Secu !== '' && dateNaissance !== '') {
                                    submitBtn.classList.add('active');
                                } else {
                                    submitBtn.classList.remove('active');
                                }
                            });
                        });
                        var submitBtn = document.getElementById('bouton_valider');
                    </script>
                </form>
            </div>
        </div>
    </body>

    <?php include 'footer.php'; ?>
    
</html>
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
            <div id="formulaire" class="formulaire" style="display:block;">
                <form id="rdvForm" method="post" action="traitements/traitement_modifier_rdv.php" onsubmit="return Valide()">
                    <?php
                        $date = $_GET['date'];
                        $heure_debut = $_GET['heure_debut'];
                        $heure_fin = $_GET['heure_fin'];
                        $idMedecin = $_GET['medecin'];
                        $idUsager = $_GET['usager'];
                    ?>
                    <input type="hidden" id="usager_ancien" name="usager_ancien" value="<?php echo $idUsager; ?>">
                    <input type="hidden" id="medecin_ancien" name="medecin_ancien" value="<?php echo $idMedecin; ?>">
                    <input type="hidden" id="date_ancienne" name="date_ancienne" value="<?php echo $date; ?>">
                    <input type="hidden" id="heure_debut_ancienne" name="heure_debut_ancienne" value="<?php echo $heure_debut; ?>">
                    <input type="hidden" id="heure_fin_ancienne" name="heure_fin_ancienne" value="<?php echo $heure_fin; ?>">
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
                                $selected = null;
                                if ($id == $idUsager){
                                    $selected = "selected";
                                }
                                echo "<option value='$id' data-medecin-referent='$medecinReferent' $selected>$nom $prenom</option>";
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
                                $selected = null;
                                if ($id == $idMedecin){
                                    $selected = "selected";
                                }
                                echo "<option value='$id' $selected>$nom $prenom</option>";
                            }
                        ?>
                    </select>

                    <label for="date">Date :</label>
                    <input type="date" id="date" name="date" required value="<?php echo $date; ?>">

                    <label for="heure_debut">Heure de début :</label>
                    <input type="time" id="heure_debut" name="heure_debut" required value="<?php echo $heure_debut; ?>">

                    <label for="heure_fin">Heure de fin :</label>
                    <input type="time" id="heure_fin" name="heure_fin" required value="<?php echo $heure_fin; ?>">

                    <input type="submit" id="bouton_valider" value="Modifier">
                </form>
            </div>
        </div>
    </body>
    <?php include 'footer.php'; ?>
</html>

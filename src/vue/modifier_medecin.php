<?php clearstatcache();
?>

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
                <form id="form" method="post" action="traitement_modifier_medecin.php" onsubmit="return Valide()">
                    <label for="prenom">Prénom:</label>
                    <?php
                        $prenom = $_GET['prenom'];
                        $nom = $_GET['nom'];
                        $civilite=$_GET['civilite'];
                        $idMedecin= $_GET['id'];
                    ?>
                    <input type="hidden" name="idMedecin" value="<?php echo $idMedecin; ?>">

                    <input type="text" id="prenom" name="prenom" autocomplete="off" value="<?php echo $prenom; ?>">

                    <label for="nom">Nom:</label>
                    <input type="text" id="nom" name="nom" autocomplete="off" value="<?php echo $nom; ?>">

                    <label for="civilite">Civilité:</label>
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
                    
                    <a href="medecins.php"><input type="button" id="bouton_annuler" value="Annuler"></a>
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
                        bouton_valider.classList.add('active');
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
        </div>
    
</html>
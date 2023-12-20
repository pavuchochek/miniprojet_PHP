<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test medecin</title>
    <link rel="stylesheet" href="css/CSSheader.css">
    <link rel="stylesheet" href="css/CSSfooter.css">
    <style>
        div#formulaire {
            display: none;
        }
    </style>
</head>
<?php include 'header.php'; ?>
<body>
    <div class="body">
        <h1>Liste des médecins</h1>

        <button id="afficherFormulaire">Afficher le formulaire du médecin</button>

        <div id="formulaire">
            <!-- Le contenu du formulaire -->
            <form method="post" action="traitement_formulaire.php">
                <!-- Ajoutez ici les champs de votre formulaire -->
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom">
                <br>
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom">
                <br>
                <!-- Ajoutez d'autres champs selon vos besoins -->
                <input type="submit" value="Envoyer">
            </form>
        </div>
    </div>

    <script>
        document.getElementById('afficherFormulaire').addEventListener('click', function() {
            var formulaire = document.getElementById('formulaire');
            if (formulaire.style.display == 'block')
                formulaire.style.display = 'none';
            else
                formulaire.style.display = 'block';
        });
    </script>
</body>
<?php include 'footer.php'; ?>
<script>
        document.addEventListener('DOMContentLoaded', handleScroll);
    </script>
</html>
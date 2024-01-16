<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Accueil</title>
        <link rel="stylesheet" href="css/CSSaccueil.css">
        <link rel="stylesheet" href="css/CSSheader.css">
        <link rel="stylesheet" href="css/CSSfooter.css">
        <link rel="icon" href="img/logo.png">
    </head>

    <?php include 'header.php'; ?>

    <body>
        <div id="menu" class="body">
            <a href="medecins.php">
                <img src="img/icone_menu_medecin.png" alt="logo">
                <input type="button" value="Médecins">
            </a>
            <a href="usagers.php">
                <img src="img/icone_menu_usager2.png" alt="logo">
                <input type="button" value="Patients">
            </a>
            <a href="rdv.php">
                <img src="img/icone_menu_rdv.png" alt="logo">
                <input type="button" value="Rendez-vous">
            </a>
            <a href="statistiques.php">
                <img src="img/image_icone_stats.png" alt="logo">
                <input type="button" value="Statistiques">
            </a>
        </div>
    </body>

    <?php include 'footer.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', flecheHaut);
    </script>
</html>
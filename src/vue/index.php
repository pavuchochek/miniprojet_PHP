<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Accueil</title>
        <link rel="stylesheet" href="css/CSSaccueil.css">
        <link rel="stylesheet" href="css/CSSheader.css">
        <link rel="stylesheet" href="css/CSSfooter.css">
    </head>

    <?php include 'header.php'; ?>

    <body>
        <div id="menu" class="decalage_header">
            <a href="medecins.php">
                <img src="img/icone_menu_medecin.png" alt="logo">
                <input type="button" value="Liste des médecins">
            </a>
            <a href="usagers.php">
                <img src="img/icone_menu_usager.png" alt="logo">
                <input type="button" value="Liste des usagers">
            </a>
            <a href="rdv.php">
                <img src="img/icone_menu_rdv.png" alt="logo">
                <input type="button" value="Liste des rendez-vous">
            </a>
        </div>
    </body>

    <?php include 'footer.php'; ?>
</html>
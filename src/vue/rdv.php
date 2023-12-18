<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Rdv</title>
        <link rel="stylesheet" href="css/CSSrdv.css">
        <link rel="stylesheet" href="css/CSSheader.css">
        <link rel="stylesheet" href="css/CSSfooter.css">
    </head>

    <?php include 'header.php'; ?>

    <body>
        <div class="body">
            <h1>Liste des rdv</h1>
            <?php
            for ($i = 1; $i <= 50; $i++) {
                echo "<p>Paragraph $i</p>";
            }
            ?>
        </div>
    </body>

    <?php include 'footer.php'; ?>
    <script>
        // Appeler la fonction au chargement de la page
        document.addEventListener('DOMContentLoaded', handleScroll);
    </script>
</html>
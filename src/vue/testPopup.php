<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popup Example</title>
    <link rel="stylesheet" href="styles.css"> <!-- Ajoutez une feuille de style si nécessaire -->
</head>
<body>

    <!-- Votre contenu de page ici -->

    <?php
        // Vérifiez si le pop-up doit être affiché (par exemple, en fonction d'une condition PHP)
        $showPopup = true;

        // Utilisez une classe CSS pour afficher ou cacher le pop-up
        $popupClass = $showPopup ? 'popup show' : 'popup hide';

        echo '<div class="' . $popupClass . '">
                <div class="popup-content">
                    <span class="close" onclick="closePopup()">&times;</span>
                    <p>Contenu de votre pop-up ici.</p>
                </div>
            </div>';
    ?>

    <!-- Votre contenu de page ici -->

</body>
</html>

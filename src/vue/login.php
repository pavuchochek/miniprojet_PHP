<?php
    session_start();

    // Vérifie si l'utilisateur est déjà connecté, redirige vers la page d'accueil
    if (isset($_SESSION['utilisateur_connecte'])) {
        header("Location: index.php");
        exit();
    }

    // Vérifie si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifie les identifiants (remplace cela par la vérification réelle, par exemple en interrogeant une base de données)
        $nom_utilisateur_attendu = "unnomlambda";
        $mot_de_passe_attendu = "vraimotdepasse";

        $nom_utilisateur = $_POST["nom_utilisateur"];
        $mot_de_passe = $_POST["mot_de_passe"];

        if ($nom_utilisateur == $nom_utilisateur_attendu && $mot_de_passe == $mot_de_passe_attendu) {
            // Identifiants corrects, enregistre la session et redirige vers la page d'accueil
            $_SESSION['utilisateur_connecte'] = true;
            header("Location: index.php");
            exit();
        } else {
            // Identifiants incorrects, affiche un message d'erreur
            $message_erreur = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Connexion - Cabinet Médical</title>
    <link rel="stylesheet" href="css/CSSlogin.css">
</head>
<body>

    <div class="container">
        <h2 class="titreConnexion">Connexion</h2>

        <?php if (isset($message_erreur)) : ?>
            <p class = "messageErreur"><?php echo $message_erreur; ?></p>
        <?php endif; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="formulaireConnexion">
            <label for="nom_utilisateur" class="label label_user">Nom d'utilisateur:</label>
            <input type="text" id="nom_utilisateur" name="nom_utilisateur" value="" required autocomplete="off"><br>

            <label for="mot_de_passe" class = "label label_mdp">Mot de passe:</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" value="" required autocomplete="off"><br>

            <input type="submit" value="Se connecter" class="boutonConnexion">
        </form>
    </div>
</body>
</html>
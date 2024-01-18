<?php
    session_start();

    // Vérifie si l'utilisateur est déjà connecté, redirige vers la page d'accueil
    if (isset($_SESSION['utilisateur_connecte'])) {
        header("Location: accueil.php");
        exit();
    }

    // Vérifie si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifie les identifiants (remplace cela par la vérification réelle, par exemple en interrogeant une base de données)
        $nom_utilisateur_attendu = "user";
        $mot_de_passe_attendu = "iutinfo";

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
    <title>Connexion</title>
    <!-- Ajoute tes styles CSS ici si nécessaire -->
</head>
<body>

    <h2>Connexion</h2>

    <?php if (isset($message_erreur)) : ?>
        <p style="color: red;"><?php echo $message_erreur; ?></p>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nom_utilisateur">Nom d'utilisateur:</label>
        <input type="text" id="nom_utilisateur" name="nom_utilisateur" value="user" required><br>

        <label for="mot_de_passe">Mot de passe:</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" value="iutinfo" required><br>

        <input type="submit" value="Se connecter">
    </form>

</body>
</html>
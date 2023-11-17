<head>
    <meta charset="utf-8" />
    <title>Medecins</title>
</head>
<body>
<h1>Liste des medecins</h1>
<?php
    include("modele/pdo.php");
    $controleur=new Medecin_controleur();
    $resultat=$controleur->liste_medecins();
    echo $resultat;
?>
ui
<input type="button" value="Ajouter un medecin">
</body>
<head>
    <meta charset="utf-8" />
    <title>Medecins</title>
</head>
<body>
<h1>Liste des medecins</h1>
<?php
    require($_SERVER['DOCUMENT_ROOT'].'/miniProjet_php/modele/classes.php');
    $controleur = new Medecin_controleur();
    $resultat=$controleur->liste_medecins();
    echo count($resultat);
    foreach ($resultat as $value){

        echo "<div><div>".$value->getNom()."</div>"."<div>".$value->getPrenom()."</div></div>";
    }
?>
<input type="button" value="Ajouter un medecin">
</body>
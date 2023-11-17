<head>
    <meta charset="utf-8" />
    <title>Medecins</title>
</head>
<body>
<h1>Liste des medecins</h1>
<?php
    include($_SERVER['DOCUMENT_ROOT'].'/miniProjet_php/controleur/medecin.controleur.php');
    $controleur=new Medecin_controleur();
    $resultat=$controleur->liste_medecins();
    while ($data = $resultat->fetch()) {
        echo $data[0].'<br/>'.$data[1].'<br/>';
    }
    
?>
<input type="button" value="Ajouter un medecin">
</body>
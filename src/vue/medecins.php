<?php 
clearstatcache();
?>
<head>
    <meta charset="utf-8" />
    <title>Medecins</title>
    <link rel="stylesheet" href="css/CSSmedecin.css">
</head>

<header>
    <a href="index.php">
        <img src="img/logo.png" alt="logo">
    </a>
    <h1>Accueil Cabinet Médical</h1>
</header>

<body>
<h1>Liste des medecins</h1>

<div class="box_medecin">

<?php
    require($_SERVER['DOCUMENT_ROOT'].'/miniProjet_php/src/modele/classes.php');
    $controleur = new Medecin_controleur();
    $resultat=$controleur->liste_medecins();
    foreach ($resultat as $value){
        echo "<div class='item_medecin'>
        <img class='icone_liste_medecin' src='img/icone_homme.png' alt='icone d'un medecin'/>
        <div class='nom'>".$value->getNom()."</div>"."<div>".$value->getPrenom()."</div></div>";
    }
?>
</div>
<div class="boutons_modif" >
<input type="button" value="Ajouter un medecin">
</div>
</body>
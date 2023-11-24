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
?>
 <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
<input type="button" value="Ajouter un medecin">
</body>
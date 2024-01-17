<?php clearstatcache();?>
<header id = "top">
    <a href="index.php">
        <img src="img/logo.png" alt="logo" id = "logo">
    </a>
    <h1 id='Titreaccueil'>Cabinet Médical</h1>
    <h1 id='Titremédecin'>Médecins</h1>
    <h1 id='Titrepatient'>Patients</h1>
    <h1 id='Titrerdv'>Rendez-vous</h1>
    <h1 id='Titrestats'>Statistiques</h1>
    <div id="boutons">
        <a href="index.php" id="header_accueil"><input type="button" value="Accueil"></a>
        <a href="medecins.php" id="header_medecin"><input type="button" value="Médecins"></a>
        <a href="usagers.php" id="header_user"><input type="button" value="Patients"></a>
        <a href="rdv.php?usagerFilter=&medecinFilter=" id="header_rdv"><input type="button" value="Rendez-vous"></a>
    </div>
    <a href="#top" class="retourHaut">
        <img src="img\flecheHeader.png">
    </a>

    <script>
        function flecheHaut() {
            var header = document.querySelector('header');
            var Element = document.querySelector('.retourHaut');
            if (window.scrollY > header.offsetHeight) {
                Element.style.display = 'flex';
            } else {
                Element.style.display = 'none';
            }
            window.addEventListener('scroll', function() {
                var headerHeight = header.offsetHeight;
                var scrollPosition = window.scrollY || window.pageYOffset;
                if (scrollPosition > headerHeight) {
                    Element.style.display = 'flex';
                } else {
                    Element.style.display = 'none';
                }
            });
        }
        document.addEventListener('DOMContentLoaded', flecheHaut);
    </script>
</header>
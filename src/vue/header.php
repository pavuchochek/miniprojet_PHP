
<header id = "top">
    <a href="index.php">
        <img src="img/logo.png" alt="logo">
    </a>
    <h1>Cabinet Médical</h1>
    <div id="boutons">
        <a href="index.php" id="header_accueil"><input type="button" value="Accueil"></a>
        <a href="medecins.php" id="header_medecin"><input type="button" value="Médecins"></a>
        <a href="usagers.php" id="header_user"><input type="button" value="Usagers"></a>
        <a href="rdv.php" id="header_rdv"><input type="button" value="Rendez-vous"></a>
    </div>
    <a href="#top" class="retourHaut">
        <img src="img\flecheHeader.png">
    </a>

    <script>
        function handleScroll() {
            console.log('handleScroll function called');

            var header = document.querySelector('header');
            var Element = document.querySelector('.retourHaut');

            if (window.scrollY > header.offsetHeight) {
                testEleElementment.style.display = 'flex';
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
        document.addEventListener('DOMContentLoaded', handleScroll);
    </script>
</header>
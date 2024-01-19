<!DOCTYPE html>
<html lang="fr">
    <footer>
        <div id="footer">
            <div class="olalala" onclick="afficherPopupDéconnexion()">
                <input type="button" id="afficherPopupDéconnexion" value="Déconnexion">
            </div>
            <a href ="statistiques.php" class="olalala">
                <input type="button" value="Statistiques">
            </a>
            <p>Site réalisé par : </p>
            <a class="linkfooter" href="https://limit-breker.gamingdy.fr/" target = "_blank">Simon Armand et Sofia Gribanova</p></a>
        </div>
        <div id = "popup_deconnexion">
            <div id = "popup_deconnexion_content">
                <p>Êtes-vous sûr de vouloir vous déconnecter ?</p>
                <div id = "popup_deconnexion_buttons">
                    <form method="post" action="logout.php">
                        <input type="submit" value="Oui">
                    </form>
                    <button onclick="closePopup()">Non</button>
                </div>
            </div>
        </div>
    </footer>
    <script>
        function closePopup() {
            document.getElementById("popup_deconnexion").style.display = "none";
        }
        
        var popupVisible = false;
        function afficherPopupDéconnexion() {
            if (popupVisible) {
                document.getElementById("popup_deconnexion").style.display = "none";
                popupVisible = false;
            } else {
                document.getElementById("popup_deconnexion").style.display = "block";
                popupVisible = true;
            }
        }
    </script>
</html>
<?php
    require('/app/src/controleur/rdv.controleur.php');

    $controleur = new Rdv_Controleur();
    $patient = $_POST["usager"];
    $medecin = $_POST["medecin"];
    $date = $_POST["date"];
    $heure_debut = $_POST["heure_debut"];
    $heure_fin = $_POST["heure_fin"];
    $dayOfWeek = date('N', strtotime($date));
    $currentDate = date('Y-m-d');
    
    if ($date < $currentDate) {
        echo "La date est invalide, vous ne pouvez pas créer un rendez-vous qui est déjà passé.";
        echo "<br>";
        echo "Le ".$date." est avant le ".$currentDate;
        echo "<br>";
        echo "<a href='/rdv.php'>Go back</a>";
        exit;
    }

    if ($heure_debut > $heure_fin) {
        echo "L'horaire est invalide, l'heure de début est avant l'heure de fin.";
        echo "<br>";
        echo $heure_debut." - ".$heure_fin;
        echo "<br>";
        echo "<a href='/rdv.php'>Go back</a>";
        exit;
    }
    
    if ($dayOfWeek >= 1 && $dayOfWeek <= 5) {
        if ($heure_debut >= "08:00" && $heure_debut <= "19:00" && $heure_fin >= "08:00" && $heure_fin <= "19:00") {
            $controleur->creationRdv($patient, $medecin, $date, $heure_debut, $heure_fin);
            header('Location: /rdv.php');
            exit;
        } else {
            echo "Les horaires d'ouvertures du cabinet sont de 8h à 19h. Vous ne pouvez pas mettre un rendez-vous en dehors de ces horaires.";
            echo "<br>";
            echo "Heure de début : ".$heure_debut;
            echo "<br>";
            echo "Heure de fin : ".$heure_fin;
            echo "<br>";
            echo "<a href='/rdv.php'>Go back</a>";
        }
    } else {
        echo "Le cabinet n'est ouvert qu'en semaine, vous ne pouvez pas planifier un rendez-vous un week-end.";
        echo "<br>";
        $dateObj = new DateTime($date);
        $jourSemaineIndex = (int)$dateObj->format('w');
        $joursEnFrancais = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $jourSemaine = $joursEnFrancais[$jourSemaineIndex];
        echo "Le " . $date . " est un " . $jourSemaine;
        echo "<br>";
        echo "<a href='/rdv.php'>Go back</a>";
    }
?>

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
    if($controleur->creneau_disponible($medecin,$patient,$date,$heure_debut,$heure_fin)){
        session_start();
        $_SESSION['erreur_message'] = "Le creneau pour ce medecin ou usager n'est pas disponible ";
        header("Location: ../rdv.php?idmedecin=null");
        exit();
    }
    if ($date < $currentDate) {
        session_start();
        $_SESSION['erreur_message'] = "La date est invalide, vous ne pouvez pas créer un rendez-vous qui est déjà passé.<br>Le ".$date." est avant le ".$currentDate;
        header("Location: ../rdv.php?idmedecin=null");
        exit();
    }

    if ($heure_debut > $heure_fin) {
        session_start();
        $_SESSION['erreur_message'] = "L'horaire est invalide, l'heure de début est avant l'heure de fin.<br>".$heure_debut." - ".$heure_fin;
        header("Location: ../rdv.php?idmedecin=null");
        exit();
    }
    if($controleur->isMemePersonne($patient,$medecin)){
        session_start();
        $_SESSION['erreur_message'] = "On ne peut pas set la meme personne pour un rdv";
        header("Location: ../rdv.php?idmedecin=null");
        exit();
    }
    if ($dayOfWeek >= 1 && $dayOfWeek <= 5) {
        if ($heure_debut >= "08:00" && $heure_debut <= "19:00" && $heure_fin >= "08:00" && $heure_fin <= "19:00") {
            $controleur->creationRdv($patient, $medecin, $date, $heure_debut, $heure_fin);
            header('Location: /rdv.php');
            exit;
        } else {
            session_start();
            $_SESSION['erreur_message'] = "Les horaires d'ouverture du cabinet sont de 8h à 19h. Vous ne pouvez pas mettre un rendez-vous en dehors de ces horaires.<br>Heure de début :<br>Heure de fin :<br>";
            header("Location: ../rdv.php?idmedecin=null");
            exit();
        }
    } else {
        $dateObj = new DateTime($date);
        $jourSemaineIndex = (int)$dateObj->format('w');
        $joursEnFrancais = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $jourSemaine = $joursEnFrancais[$jourSemaineIndex];
        session_start();
        $_SESSION['erreur_message'] = "Le cabinet n'est ouvert qu'en semaine, vous ne pouvez pas planifier un rendez-vous un week-end.<br>Le " . $date . " est un " . $jourSemaine;
        header("Location: ../rdv.php?idmedecin=null");
        exit();
    }
?>

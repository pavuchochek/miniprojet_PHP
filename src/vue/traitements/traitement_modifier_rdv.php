<?php
    require('../../controleur/rdv.controleur.php');

    $controleur = new Rdv_controleur();
    $idUsager = $_POST['usager'];
    $idMedecin = $_POST['medecin'];
    $date = $_POST['date'];
    $heure_debut = $_POST['heure_debut'];
    $heure_fin = $_POST['heure_fin'];
    $idUsager_ancien = $_POST['usager_ancien'];
    $idMedecin_ancien = $_POST['medecin_ancien'];
    $date_ancienne = $_POST['date_ancienne'];
    $heure_debut_ancienne = $_POST['heure_debut_ancienne'];
    $heure_fin_ancienne = $_POST['heure_fin_ancienne'];

    $dayOfWeek = date('N', strtotime($date));
    $currentDate = date('Y-m-d');
    
    if ($date < $currentDate) {
        session_start();
        $_SESSION['erreur_message'] = "La date est invalide, vous ne pouvez pas modifier un rendez-vous pour une date déjà passée.";
        header("Location: ../modifier_rdv.php?usager=".$idUsager_ancien."&medecin=".$idMedecin_ancien."&date=".$date_ancienne."&heure_debut=".$heure_debut_ancienne."&heure_fin=".$heure_fin_ancienne);
        exit();
    }
    if($controleur->isMemePersonne($idUsager,$idMedecin)){
        session_start();
        $_SESSION['erreur_message'] = "On ne peut pas set la meme personne pour un rdv";
        header("Location: ../modifier_rdv.php?usager=".$idUsager_ancien."&medecin=".$idMedecin_ancien."&date=".$date_ancienne."&heure_debut=".$heure_debut_ancienne."&heure_fin=".$heure_fin_ancienne);
        exit();
    }

    if ($heure_debut > $heure_fin) {
        session_start();
        $_SESSION['erreur_message'] = "L'horaire est invalide, l'heure de début est avant l'heure de fin.";
        header("Location: ../modifier_rdv.php?usager=".$idUsager_ancien."&medecin=".$idMedecin_ancien."&date=".$date_ancienne."&heure_debut=".$heure_debut_ancienne."&heure_fin=".$heure_fin_ancienne);
        exit();
    }
    
    if ($dayOfWeek >= 1 && $dayOfWeek <= 5) {
        if ($heure_debut >= "08:00" && $heure_debut <= "19:00" && $heure_fin >= "08:00" && $heure_fin <= "19:00") {
            $controleur->modifierRdv($idMedecin_ancien,$idUsager_ancien,$date_ancienne,$heure_debut_ancienne,$heure_fin_ancienne,$idMedecin,$idUsager,$date,$heure_debut,$heure_fin);
            header("Location: ../rdv.php");
            exit;
        } else {
            session_start();
            $_SESSION['erreur_message'] = "Les horaires d'ouverture du cabinet sont de 8h à 19h. Vous ne pouvez pas mettre un rendez-vous en dehors de ces horaires.<br>Heure de début :<br>Heure de fin :<br>";
            header("Location: ../modifier_rdv.php?usager=".$idUsager_ancien."&medecin=".$idMedecin_ancien."&date=".$date_ancienne."&heure_debut=".$heure_debut_ancienne."&heure_fin=".$heure_fin_ancienne);
            exit();
        }
    } else {
        $dateObj = new DateTime($date);
        $jourSemaineIndex = (int)$dateObj->format('w');
        $joursEnFrancais = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $jourSemaine = $joursEnFrancais[$jourSemaineIndex];
        session_start();
        $_SESSION['erreur_message'] = "Le cabinet n'est ouvert qu'en semaine, vous ne pouvez pas planifier un rendez-vous un week-end.<br>Le " . $date . " est un " . $jourSemaine;
        header("Location: ../modifier_rdv.php?usager=".$idUsager_ancien."&medecin=".$idMedecin_ancien."&date=".$date_ancienne."&heure_debut=".$heure_debut_ancienne."&heure_fin=".$heure_fin_ancienne);
        exit();
    }
?>

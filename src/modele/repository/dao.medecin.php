<?php
include_once('/app/src/modele/repository/pdo.php');
include_once('/app/src/controleur/medecin.controleur.php');
include_once('/app/src/modele/classes/medecin.class.php');
include_once('/app/src/modele/classes/usagers.class.php');
include_once('/app/src/modele/classes/rdv.class.php');

class Dao_Medecin {

    private $pdo;

    // Constructeur chargé d'ouvrir la BD
    public function __construct() {
        include('/app/configuration.php');
        $this->pdo = Connexion::getInstance($db_address, $user, $password, $db_name);
    }

    //Retourne l'id du médecin correspondant au nom et prénom
    public function getIdMedecinByPrenomNom($prenom, $nom) {
        try {
            $req = $this->pdo->prepare('SELECT Medecin.Id_Medecin
                FROM Medecin
                JOIN Personne ON Medecin.Id_Personne = Personne.Id_Personne
                WHERE Personne.Prenom = :prenom AND Personne.Nom = :nom');
            
            $req->execute(array(
                'prenom' => $prenom,
                'nom' => $nom
            ));
            
            $result = $req->fetch();

            return ($result) ? $result['Id_Medecin'] : null;
        } catch (PDOException $e) {
            // En cas d'erreur, afficher le message d'erreur
            error_log("Error executing SQL query: " . $e->getMessage());
            throw $e;
        }
    }

    //Retourne le médecin correspondant à l'id
    public function getMedecinById(int $idMedecin): Medecin {
        try {
            $req = $this->pdo->prepare('SELECT Personne.Nom, Personne.Prenom, Personne.Civilite, Personne.Id_Personne, Medecin.Id_Medecin
                FROM Medecin,Personne
                WHERE Medecin.Id_Medecin = :id AND Medecin.Id_Personne = Personne.Id_Personne');
            $req->execute(array(
                'id' => $idMedecin
            ));

            $data = $req->fetch();

            if (!$data) {
                throw new Exception("Aucun médecin trouvé avec l'ID : $idMedecin");
            }

            $personne = new Personne($data['Nom'], $data['Prenom'], $data['Civilite']);
            $personne->setId($data['Id_Personne']);
            $medecin = new Medecin($personne);
            $medecin->setIdMedecin($data['Id_Medecin']);

            return $medecin;
        } catch (PDOException $e) {
            // En cas d'erreur, afficher le message d'erreur
            error_log("Error executing SQL query: " . $e->getMessage());
            throw $e;
        } catch (Exception $ex) {
            // Ajoutez des messages de débogage
            error_log("Exception catched: " . $ex->getMessage());
        
            // Relancez l'exception pour qu'elle remonte
            throw $ex;
        }
    }

    //Retourne la liste des médecins correspondant aux critères de recherche
    public function liste_medecins(String $nom, String $prenom) {
        try {
            if ($nom == "" && $prenom == "") {
                $res = $this->pdo->query('SELECT Personne.Nom,Personne.Prenom,Personne.Civilite,Personne.Id_Personne,Medecin.Id_Medecin
                FROM Medecin,Personne 
                WHERE Medecin.Id_Personne=Personne.Id_Personne');
                $tablo_medecins = array();
                while ($data = $res->fetch()) {
                    $personne = new Personne($data[0], $data[1], $data[2]);
                    $personne->setId($data[3]);
                    $medecin = new Medecin($personne);
                    $medecin->setIdMedecin($data[4]);
                    $tablo_medecins[] = $medecin;
                }
            } else {
                $tablo_medecins = array(); // Aucun médecin trouvé avec les critères de recherche
            }
            return $tablo_medecins;
        } catch (PDOException $e) {
            // En cas d'erreur, afficher le message d'erreur
            error_log("Error executing SQL query: " . $e->getMessage());
            throw $e;
        }
    }

    //Retourne la liste des usagers du médecin
    public function liste_usager_medecin(Medecin $medecin){
        try{
            $req = $this->pdo->prepare('SELECT DISTINCT Personne.Nom,Personne.Prenom,Personne.Civilite,Usager.N_securite_sociale,Usager.Adresse,Usager.Date_naissance,Usager.Lieu_naissance,Usager.Id_Personne,Usager.Id_Usager
             FROM Usager,Personne WHERE Usager.Id_Personne=Personne.Id_Personne AND Usager.Id_Medecin = :id');
        $req->execute(array(
            'id' => $medecin->getIdMedecin()
        ));
        $tablo_usagers = array();
        while ($data = $req->fetch()) {
            $personne = new Personne($data[0], $data[1], $data[2]);
            $personne->setId($data[7]);
            $usager = new Usager($personne, $data[3], $data[4],$data[5],$data[6],$medecin);
            $usager->setIdUsager(intval($data[8]));
            $tablo_usagers[] = $usager;
        }
        return  $tablo_usagers;
        }catch(PDOException $e) {
            error_log("". $e->getMessage());
        }
    }

    //Ajoute un médecin
    public function ajouter_medecins(Medecin $medecin) {
        try {
            $req = $this->pdo->prepare('INSERT INTO Personne (Nom,Prenom,Civilite) VALUES (:nom,:prenom,:civilite)');
            $req->execute(array(
                'nom' => $medecin->getNom(),
                'prenom' => $medecin->getPrenom(),
                'civilite' => $medecin->getCivilite()
            ));
            $id = $this->pdo->lastInsertId();
            $req = $this->pdo->prepare('INSERT INTO Medecin (Id_Personne) VALUES (:id)');
            $req->execute(array(
                'id' => $id
            ));
        } catch (PDOException $e) {
            // En cas d'erreur, afficher le message d'erreur
            error_log("Error executing SQL query: " . $e->getMessage());
            throw $e;
        }
    }

    //Supprime un médecin référent d'un usager
    public function supprimer_medecin_referentByIdUsager(int $idMedecin,int $idUsager){
        try {
            $req = $this->pdo->prepare('UPDATE Usager SET Id_Medecin=NULL WHERE Id_Medecin = :id AND Id_Usager = :idUsager');
            $req->execute(array(
                'id' => $idMedecin,
                'idUsager' => $idUsager
            ));
        }catch (PDOException $e) {
            throw $e;
        }
    }

    //Supprime un médecin
    public function supprimer_medecins(Medecin $medecin) {

        try {
            $req = $this->pdo->prepare('UPDATE Usager SET Id_Medecin=NULL WHERE Id_Medecin=:id;');
            $req->execute(array(
                'id' => $medecin->getIdMedecin()
            ));
            $req = $this->pdo->prepare('DELETE FROM Rdv WHERE Id_Medecin=:id;');
            $req->execute(array(
                'id' => $medecin->getIdMedecin()
            ));
            $req = $this->pdo->prepare('DELETE FROM Medecin WHERE Id_Medecin=:id;');
            $req->execute(array(
                'id' => $medecin->getIdMedecin()
            ));
            //SI LA PERSONNE EST NI MEDECIN NI USAGER ON LA SUPPRIME DEFINITIVEMENT
            $req = $this->pdo->prepare('SELECT * from Usager where Id_Personne=:id');
            $req->execute(array(
                'id' => $medecin->getId()
            ));
            $data = $req->fetch();
            if (!$data) {
                $req = $this->pdo->prepare('DELETE FROM Personne WHERE Id_Personne=:id;');
                $req->execute(array(
                    'id' => $medecin->getId()
                ));
            }
        } catch (PDOException $e) {
            // En cas d'erreur, afficher le message d'erreur
            error_log("Error executing SQL query: " . $e->getMessage());
            throw $e;
        }
    }

    //Modifie un médecin
    public function modifier_medecins(Medecin $medecin,String $nouveauNom,String $nouveauPrenom,String $nouvelleCivilite){
        $req=$this->pdo->prepare('UPDATE Personne SET Nom=:nom,Prenom=:prenom,Civilite=:civilite WHERE Id_Personne=:id');
        $req->execute(array(
            'nom'=>$nouveauNom,
            'prenom'=>$nouveauPrenom,
            'civilite'=>$nouvelleCivilite,
            'id'=>$medecin->getId()
        ));
    }

    //Retourne la liste des usagers qui n'ont pas le médecin en référent
    public function liste_usagers_medecin_non_referent(int $idMedecin){
            try{
                $req = $this->pdo->prepare('SELECT DISTINCT Usager.N_securite_sociale,Usager.Adresse,Usager.Date_naissance,Usager.Lieu_naissance,Usager.Id_Personne,Usager.Id_Usager,Usager.Id_Medecin
                FROM Usager,Personne WHERE Usager.Id_Medecin != :idMedecin OR Usager.Id_Medecin IS NULL');
            $req->execute(array(
                'idMedecin'=>$idMedecin));
            $tablo_usagers = array();
            while ($data = $req->fetch()) {
                $personne = $this->getPersonneById($data[4]);
                $medecin=null;
                if(!is_null($data[6])){
                    $medecin = $this->getMedecinById($data[6]);
                }
                $usager = new Usager($personne, $data[0], $data[1],$data[2],$data[3],$medecin);
                $usager->setIdUsager(intval($data[5]));
                $tablo_usagers[] = $usager;
            }
            return  $tablo_usagers;
            }catch(PDOException $e) {
                error_log("". $e->getMessage());
            }
    }

    //Retourne la personne correspondant à l'id
    public function getPersonneById(int $idPersonne){
        try{
            $req = $this->pdo->prepare('SELECT Personne.Nom,Personne.Prenom,Personne.Civilite FROM Personne WHERE Id_Personne = :idPersonne');
            $req->execute(array(
                'idPersonne'=>$idPersonne));
            $data = $req->fetch();
            $personne=new Personne($data[0],$data[1],$data[2]);
            $personne->setId($idPersonne);
            return $personne;
        }catch(PDOException $e){
            error_log("". $e->getMessage());
        }
    }

    //Retourne la liste des rdv du médecin
    public function liste_rdv(Medecin $medecin) {
        // Recherche des rdv avec les informations de l'usager
        $tablo_rdv = array();
        $res = $this->pdo->prepare('
            SELECT Rdv.Id_Usager, Rdv.Date_rdv, Rdv.Heure_debut, Rdv.Heure_fin,
                   Personne.Nom AS Usager_Nom, Personne.Prenom AS Usager_Prenom,
                   Personne.Civilite AS Usager_Civilite, Usager.N_securite_sociale,
                   Usager.Adresse, Usager.Date_naissance, Usager.Lieu_naissance,
                   Usager.Id_Usager
            FROM Rdv
            JOIN Usager ON Rdv.Id_Usager = Usager.Id_Usager
            JOIN Personne ON Usager.Id_Personne = Personne.Id_Personne
            WHERE Rdv.Id_Medecin = :id
            ORDER BY Rdv.Date_rdv, Rdv.Heure_debut
        ');
        $res->execute(array(
            'id' => $medecin->getIdMedecin()
        ));
        while ($data = $res->fetch()) {
            // Création de l'objet Usager et Rdv
            $personne = new Personne($data['Usager_Nom'], $data['Usager_Prenom'], $data['Usager_Civilite']);
            $personne->setId($data['Id_Usager']);  
            $usager = new Usager($personne, $data['N_securite_sociale'], $data['Adresse'], $data['Date_naissance'], $data['Lieu_naissance'], $medecin);
            $usager->setIdUsager($data['Id_Usager']);
            $rdv = new Rdv($data['Date_rdv'], $data['Heure_debut'], $data['Heure_fin'], $medecin, $usager);
            $tablo_rdv[] = $rdv;
        }
        return $tablo_rdv;
    }

    //Retourne la liste des rdv du médecin à venir
    public function liste_rdv_actuel(Medecin $medecin) {
        // Recherche des rdv avec les informations de l'usager
        $tablo_rdv = array();
        $res = $this->pdo->prepare('
            SELECT Rdv.Id_Usager, Rdv.Date_rdv, Rdv.Heure_debut, Rdv.Heure_fin,
                   Personne.Nom AS Usager_Nom, Personne.Prenom AS Usager_Prenom,
                   Personne.Civilite AS Usager_Civilite, Usager.N_securite_sociale,
                   Usager.Adresse, Usager.Date_naissance, Usager.Lieu_naissance,
                   Usager.Id_Usager
            FROM Rdv
            JOIN Usager ON Rdv.Id_Usager = Usager.Id_Usager
            JOIN Personne ON Usager.Id_Personne = Personne.Id_Personne
            WHERE Rdv.Id_Medecin = :id AND Rdv.Date_rdv >= CURDATE()
            ORDER BY Rdv.Date_rdv, Rdv.Heure_debut
        ');
        $res->execute(array(
            'id' => $medecin->getIdMedecin()
        ));
        while ($data = $res->fetch()) {
            // Création de l'objet Usager et Rdv
            $personne = new Personne($data['Usager_Nom'], $data['Usager_Prenom'], $data['Usager_Civilite']);
            $personne->setId($data['Id_Usager']);  
            $usager = new Usager($personne, $data['N_securite_sociale'], $data['Adresse'], $data['Date_naissance'], $data['Lieu_naissance'], $medecin);
            $usager->setIdUsager($data['Id_Usager']);
            $rdv = new Rdv($data['Date_rdv'], $data['Heure_debut'], $data['Heure_fin'], $medecin, $usager);
            $tablo_rdv[] = $rdv;
        }
        return $tablo_rdv;
    }

    //Retourne la liste des usagers
    public function getListeUsagers() {
        try {
            $res = $this->pdo->query('SELECT Personne.Nom,Personne.Prenom,Personne.Civilite,Usager.N_securite_sociale,Usager.Adresse,Usager.Date_naissance,Usager.Lieu_naissance,Usager.Id_Personne,Usager.Id_Usager
                FROM Usager,Personne 
                WHERE Usager.Id_Personne=Personne.Id_Personne');
            $tablo_usagers = array();
            while ($data = $res->fetch()) {
                $personne = new Personne($data[0], $data[1], $data[2]);
                $personne->setId($data[7]);
                $usager = new Usager($personne, $data[3], $data[4],$data[5],$data[6],null);
                $usager->setIdUsager(intval($data[8]));
                $tablo_usagers[] = $usager;
            }
            return $tablo_usagers;
        } catch (PDOException $e) {
            error_log("". $e->getMessage());
        }
    }

    //Assigne un médecin référent à un usager
    public function assignerMedecinReferent(int $idMedecin,int $idUsager){
        try {
            $res = $this->pdo->query('UPDATE Usager SET Id_Medecin = :idMedecin WHERE Id_Usager = :idUsager');
            $res->execute(array(
                'idMedecin' => $idMedecin,
                'idUsager' => $idUsager));
        }catch(PDOException $e) {
            error_log("". $e->getMessage());
        }
    }
}
?>
<?php
include_once('../modele/repository/pdo.php');
include_once('../controleur/medecin.controleur.php');
include_once('../modele/classes/medecin.class.php');
include_once('../modele/classes/rdv.class.php');
include_once('../modele/repository/dao.usager.php');
class Dao_Medecin {
    private $pdo;

    public function __construct() {
        include_once('../../configuration.php');
        $this->pdo = Connexion::getInstance($db_address, $user, $password, $db_name);
    }


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
    public function liste_usager_medecin(Medecin $medecin){
        try{
            $req = $this->pdo->prepare('SELECT DISTINCT Personne.Nom,Personne.Prenom,Personne.Civilite,Usager.N_securite_sociale,Usager.Adresse,Usager.Date_naissance,Usager.Lieu_naissance,Usager.Id_Personne
             FROM Usager,Personne WHERE Usager.Id_Personne=Personne.Id_Personne AND Usager.Id_Medecin = :id');
        $req->execute(array(
            'id' => $medecin->getIdMedecin()
        ));
        $tablo_usagers = array();
        while ($data = $req->fetch()) {
            $personne = new Personne($data[0], $data[1], $data[2]);
            $personne->setId($data[3]);
            $usager = new Usager($personne, $data[3], $data[4],$data[5],$data[6],$medecin);
            $usager->setIdUsager(intval($data[4]));
            $tablo_usagers[] = $usager;
        }
        return  $tablo_usagers;
        }catch(PDOException $e) {
            error_log("". $e->getMessage());
        }
    }

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

    public function modifier_medecins(Medecin $medecin,String $nouveauNom,String $nouveauPrenom,String $nouvelleCivilite){
        $req=$this->pdo->prepare('UPDATE Personne SET Nom=:nom,Prenom=:prenom,Civilite=:civilite WHERE Id_Personne=:id');
        $req->execute(array(
            'nom'=>$nouveauNom,
            'prenom'=>$nouveauPrenom,
            'civilite'=>$nouvelleCivilite,
            'id'=>$medecin->getId()
        ));
    }
    
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
    
    
}
?>
<?php
include_once('../modele/repository/pdo.php');
include_once('../controleur/medecin.controleur.php');
include_once('../modele/classes/usagers.class.php');



class Dao_Usager{
    private $pdo;

    public function __construct() {
        include_once('../../configuration.php');
        $this->pdo = Connexion::getInstance($db_address, $user, $password, $db_name);
    }


    public function getUsagerById(int $idUsager): Usager {
        try {
            $resUsager = $this->pdo->prepare('
                SELECT Personne.Nom, Personne.Prenom, Personne.Civilite,
                       Usager.N_securite_sociale, Usager.Adresse, Usager.Date_naissance,
                       Usager.Lieu_naissance, Usager.Id_Personne, Usager.Id_Medecin, Usager.Id_Usager
                FROM Usager
                JOIN Personne ON Usager.Id_Personne = Personne.Id_Personne
                WHERE Usager.Id_Usager = :id
            ');
            $resUsager->execute(array(
                'id' => $idUsager
            ));
            $dataUsager = $resUsager->fetch();
    
            if (!$dataUsager) {
                throw new Exception("Aucun usager trouvé avec l'ID : $idUsager");
            }
    
            // Récupération des informations du médecin associé
            $medecin = $this->getMedecinById($dataUsager['Id_Medecin']);
    
            // Création de l'objet Usager
            $personne = new Personne($dataUsager['Nom'], $dataUsager['Prenom'], $dataUsager['Civilite']);
            $personne->setId($dataUsager['Id_Personne']);
            $usager = new Usager(
                $personne,
                $dataUsager['N_securite_sociale'],
                $dataUsager['Adresse'],
                $dataUsager['Date_naissance'],
                $dataUsager['Lieu_naissance'],
                $medecin
            );
            $usager->setIdUsager($dataUsager['Id_Usager']);
    
            return $usager;
        } catch (PDOException $e) {
            // En cas d'erreur, afficher le message d'erreur
            error_log("Error executing SQL query: " . $e->getMessage());
            throw $e;
        }
    }
    
    private function getMedecinById(int $idMedecin): ?Medecin {
        try {
            $req = $this->pdo->prepare('
                SELECT Personne.Nom, Personne.Prenom, Personne.Civilite, Personne.Id_Personne
                FROM Medecin
                JOIN Personne ON Medecin.Id_Personne = Personne.Id_Personne
                WHERE Medecin.Id_Medecin = :id
            ');
    
            $req->execute(array(
                'id' => $idMedecin
            ));
    
            $data = $req->fetch();
    
            if (!$data) {
                return null; // Aucun médecin trouvé avec l'ID : $idMedecin
            }
    
            // Création de l'objet Medecin
            $personne = new Personne($data['Nom'], $data['Prenom'], $data['Civilite']);
            $personne->setId($data['Id_Personne']);
            $medecin = new Medecin($personne);
            $medecin->setIdMedecin($idMedecin);
    
            return $medecin;
        } catch (PDOException $e) {
            // En cas d'erreur, afficher le message d'erreur
            error_log("Error executing SQL query: " . $e->getMessage());
            throw $e;
        }
    }
    
    
}
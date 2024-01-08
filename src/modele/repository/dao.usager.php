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

    public function listeUsagers(){
            try {
                
                    $res = $this->pdo->query('SELECT Personne.Nom,Personne.Prenom,Personne.Civilite,Usager.Id_Personne,
                    Usager.N_securite_sociale,Usager.Adresse,Usager.Date_naissance,Usager.Lieu_naissance,Usager.Id_Usager,Usager.Id_Medecin
                    FROM Usager,Personne
                    WHERE Usager.Id_Personne=Personne.Id_Personne');
                    $tablo_usagers = array();
                    while ($data = $res->fetch()) {
                        $personne = new Personne($data[0], $data[1], $data[2]);
                        $personne->setId($data[3]);
                        if (!is_null($data[9])){
                            $medecin=$this->getMedecinById($data[9]);
                        }else{
                            $medecin=null;
                        }
                        $usager = new Usager($personne,$data[4],$data[5],$data[6],$data[7],$medecin);
                        $usager->setIdUsager($data[8]);
                        $tablo_usagers[] = $usager;
                    }
                    return $tablo_usagers;
            } catch (PDOException $e) {
                // En cas d'erreur, afficher le message d'erreur
                error_log("Error executing SQL query: " . $e->getMessage());
                throw $e;
            }
        }
    public function addUsager(Usager $usager){
        try {
            $req = $this->pdo->prepare('INSERT INTO Personne (Nom,Prenom,Civilite) VALUES (:nom,:prenom,:civilite)');
            $req->execute(array(
                'nom' => $usager->getNom(),
                'prenom' => $usager->getPrenom(),
                'civilite' => $usager->getCivilite()
            ));
            $id = $this->pdo->lastInsertId();
            //verif si le medecin existe ou pas
            if(is_null($usager->getMedecinReferent())){
                $medecin=null;
            }else{
                $medecin=$usager->getMedecinReferent()->getIdMedecin();
            }
            $req = $this->pdo->prepare('INSERT INTO Usager (N_securite_sociale,Adresse,Date_naissance,Lieu_naissance,Id_Medecin,Id_Personne) VALUES 
            (:nsecu,:adresse,:date_naissance,:lieu_naissance,:idMedecin,:id)');
            $req->execute(array(
                'nsecu'=>$usager->getNsecuriteSociale(),
                'adresse'=>$usager->getAdresse(),
                'date_naissance'=>$usager->getDateNaissance(),
                'lieu_naissance'=>$usager->getLieuNaissance(),
                'idMedecin'=>$medecin,
                'id' => $id
            ));
        } catch (PDOException $e) {
            throw $e;
        }


    }
    public function updatePersonneByIdUsager(int $idUsager,String $nouveauNom,String $nouveauPrenom,String $nouvelleCivilite) {
        $usager=$this->getUsagerById($idUsager);
        $req=$this->pdo->prepare('UPDATE Personne SET Nom=:nom,Prenom=:prenom,Civilite=:civilite WHERE Id_Personne=:id');
        $req->execute(array(
            'nom'=>$nouveauNom,
            'prenom'=>$nouveauPrenom,
            'civilite'=>$nouvelleCivilite,
            'id'=>$usager->getId()
            ));
    }
    public function updateUsagerByIdUsager(int $idUsager,int $NSecuSociale,String $Adresse,String $Date_naissance, String $Lieu_naissance, Medecin $medecin){
        $req=$this->pdo->prepare('UPDATE Usager SET N_securite_sociale=:nsecu,Adresse=:adresse,Date_naissance=:date_naissance,
        Lieu_naissance=:lieu_naissance,Id_Medecin=:idMedecin WHERE Id_Usager=:id');
        $req->execute(array(
            'nsecu'=>$NSecuSociale,
            'adresse'=>$Adresse,
            'date_naissance'=>$Date_naissance,
            'lieu_naissance'=>$Lieu_naissance,
            'Id_Medecin'=>$medecin->getIdMedecin(),
            'id'=>$idUsager
            ));
    }
    public function deleteUsager(Usager $usager){
        $req = $this->pdo->prepare('DELETE FROM Rdv WHERE Id_Usager=:id;');
            $req->execute(array(
                'id' => $usager->getIdUsager()
            ));
            $req = $this->pdo->prepare('DELETE FROM Usager WHERE Id_Usager=:id;');
            $req->execute(array(
            'id' => $usager->getIdUsager()
            ));
             //SI LA PERSONNE EST NI MEDECIN NI USAGER ON LA SUPPRIME DEFINITIVEMENT
             $req = $this->pdo->prepare('SELECT * from Medecin where Id_Personne=:id');
             $req->execute(array(
                 'id' => $usager->getId()
             ));
             $data = $req->fetch();
             if (!$data) {
                 $req = $this->pdo->prepare('DELETE FROM Personne WHERE Id_Personne=:id;');
                 $req->execute(array(
                     'id' => $usager->getId()
                 ));
             }

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
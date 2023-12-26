<?php
include_once('../modele/repository/pdo.php');
include_once('../controleur/medecin.controleur.php');
include_once('../modele/classes/medecin.class.php');
define('LOG_FILE', 'logs.log');



class Dao_Medecin{
    
    private $c;
    private $pdo;
    public function __construct(){
        include_once('../../configuration.php');
        $this->c = Connexion::getInstance($db_address,$user,$password,$db_name);
        $this->pdo=$this->c->getConnexion();
    }   


    public function getMedecinById(int $idMedecin): Medecin
    {
        try {
            $req = $this->pdo->prepare('SELECT Personne.Nom, Personne.Prenom, Personne.Civilite, Personne.Id_Personne, Medecin.Id_Medecin
                FROM Medecin
                JOIN Personne ON Medecin.Id_Personne = Personne.Id_Personne
                WHERE Medecin.Id_Medecin = :id');
            $req->execute(array(
                'id' => $idMedecin
            ));
            
            $data = $req->fetch();
    
            // Afficher les données récupérées
            error_log("Data from database: " . print_r($data, true));
    
            $personne = new Personne($data[0], $data[1], $data[2]);
            $personne->setId($data[3]);
    
            $medecin = new Medecin($personne);
            $medecin->setIdMedecin($data[4]);
    
            return $medecin;
        } catch (PDOException $e) {
            // En cas d'erreur, afficher le message d'erreur
            error_log("Error executing SQL query: " . $e->getMessage());
            throw $e;
        }
    }
    

    public function liste_medecins(String $nom,String $prenom){
            if ($nom=="" && $prenom=="") {
                $res=$this->pdo->query('SELECT Personne.Nom,Personne.Prenom,Personne.Civilite,Personne.Id_Personne,Medecin.Id_Medecin
                FROM Medecin,Personne 
                WHERE Medecin.Id_Personne=Personne.Id_Personne');
                $tablo_medecins=array();
                while ($data = $res->fetch()) {
                    $personne=new Personne($data[0],$data[1],$data[2]);
                    $personne->setId($data[3]);
                    $medecin=new Medecin($personne);
                    $medecin->setIdMedecin($data[4]);
                    $tablo_medecins[] = $medecin;
                }
            }
            $tablo_medecins = array_reverse($tablo_medecins);
            return $tablo_medecins;
        }
    
    public function ajouter_medecins(Medecin $medecin){
        $req=$this->pdo->prepare('INSERT INTO Personne (Nom,Prenom,Civilite) VALUES (:nom,:prenom,:civilite)');
        $req->execute(array(
            'nom'=>$medecin->getNom(),
            'prenom'=>$medecin->getPrenom(),
            'civilite'=>$medecin->getCivilite()
        ));
        $id=$this->pdo->lastInsertId();
        $req=$this->pdo->prepare('INSERT INTO Medecin (Id_Personne) VALUES (:id)');
        $req->execute(array(
            'id'=>$id
        ));
    }
    
    public function supprimer_medecins(Medecin $medecin){
        $req = $this->pdo->prepare('DELETE FROM Rdv WHERE Id_Medecin=:id;commit;');
        $req->execute(array(
            'id' => $medecin->getIdMedecin()
        ));
        $req=$this->pdo->prepare('DELETE FROM Medecin WHERE Id_Medecin=:id;commit;');
        $req->execute(array(
            'id'=>$medecin->getIdMedecin()
        ));
        $req=$this->pdo->prepare('DELETE FROM Personne WHERE Id_Personne=:id;commit;');
        $req->execute(array(
            'id'=>$medecin->getId()
        ));
    }

    public function modifier_medecins(Medecin $medecin){
        $req=$this->pdo->prepare('UPDATE Personne SET Nom=:nom,Prenom=:prenom,Civilite=:civilite WHERE Id_Personne=:id');
        $req->execute(array(
            'nom'=>$medecin->getNom(),
            'prenom'=>$medecin->getPrenom(),
            'civilite'=>$medecin->getCivilite(),
            'id'=>$medecin->getId()
        ));
    }
}
?>
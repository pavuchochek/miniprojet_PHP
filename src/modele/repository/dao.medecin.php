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
        $this->c = new Connexion($db_address,$user,$password,$db_name);
        $this->pdo=$this->c->getConnexion();
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
        $req=$this->pdo->prepare('DELETE FROM Medecin WHERE Id_Personne=:id');
        $req->execute(array(
            'id'=>$medecin->getId()
        ));
        $req=$this->pdo->prepare('DELETE FROM Personne WHERE Id_Personne=:id');
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
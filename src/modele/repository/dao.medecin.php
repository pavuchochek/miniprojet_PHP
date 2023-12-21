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
                $res=$this->pdo->query('SELECT Personne.Nom,Personne.Prenom,Personne.Civilite,Medecin.id_Medecin,Personne.id_Personne 
                FROM Medecin,Personne 
                WHERE Medecin.Id_Personne=Personne.Id_Personne');
                $tablo_medecins=array();
                while ($data = $res->fetch()) {
                    $medecin=new Medecin($data[0],$data[1],$data[2],$data[3],$data[4]);
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
}
?>
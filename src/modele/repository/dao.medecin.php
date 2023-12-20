<?php
include_once('../modele/repository/pdo.php');
include_once('../controleur/medecin.controleur.php');
define('LOG_FILE', 'logs.log');



class Dao_Medecin{
    
    private $c;
    private $pdo;
    public function __construct(){
        include_once('../../configuration.php');
        $this->c = new Connexion($db_address,$user,$password,$db_name);
        $this->pdo=$this->c->getConnexion();
        $message = "Connecté";
        $this->journaliser($message);
    }   


    public function  liste_medecins(String $nom,String $prenom){
            if ($nom=="" && $prenom=="") {
                $res=$this->pdo->query('SELECT personne.Nom,personne.Prénom,personne.Civilité,médecin.id_Médecin,personne.id_Personne 
                FROM médecin,personne 
                WHERE médecin.Id_Personne=personne.Id_Personne');
                $tablo_medecins=array();
                while ($data = $res->fetch()) {
                    $medecin=new Medecin($data[0],$data[1],$data[2],$data[3],$data[4]);
                    $tablo_medecins[] = $medecin;
                }
            }
            return $tablo_medecins;
        }
}
?>
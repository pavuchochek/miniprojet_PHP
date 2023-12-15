<?php
require('../../modele/classes.php');



class daoMedecin{
    
    private $c;
    private $pdo;
    public function __construct(){
        include("../../../configuration.php");
        $this->c = new Connexion($db_address,$user,$password,$db_name);
        
        $this->pdo=$this->c->getConnexion();
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
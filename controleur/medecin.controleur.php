<?php
require($_SERVER['DOCUMENT_ROOT'].'/miniProjet_php/modele/classes.php');
class Medecin_controleur{
    private $c;
    private $pdo;
    public function __construct(){
        $this->c = new Connexion("localhost","root","344561","miniProjet_php");
        
        $this->pdo=$this->c->getConnexion();
    }
    public function  liste_medecins(){
        $res=$this->pdo->query('SELECT personne.Nom,personne.Prénom,personne.Civilité,médecin.id_Médecin,personne.id_Personne 
        FROM médecin,personne 
        WHERE médecin.Id_Personne=personne.Id_Personne');
        $tablo_medecins=array();
        while ($data = $res->fetch()) {
            $medecin=new Medecin($data[0],$data[1],$data[2],$data[3],$data[4]);
            $tablo_medecins[] = $medecin;
        }
        return $tablo_medecins;
    }
}

?>
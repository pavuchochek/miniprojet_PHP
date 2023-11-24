<?php
include($_SERVER['DOCUMENT_ROOT'].'/miniProjet_php/modele/pdo.php');
include($_SERVER['DOCUMENT_ROOT'].'/miniProjet_php/modele/medecin.class.php');
class Medecin_controleur{
    private $c;
    private $pdo;
    public function __construct(){
        $this->c = new Connexion("localhost","root","344561","miniProjet_php");
        
        $this->pdo=$this->c->getConnexion();
    }
    public function  liste_medecins(){
        $res=$this->pdo->query('SELECT personne.* 
        FROM médecin,personne 
        WHERE médecin.Id_Personne=personne.Id_Personne');
        $tablo_medecins=array();
        while ($data = $res->fetch()) {
            $tablo_medecins->new ($data[0],);
        }
        return $res;
    }
}

?>
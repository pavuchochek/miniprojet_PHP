<?php
include("pdo.php");
class Medecin_controleur{
    private $c;
    private $pdo;
    public function __construct(){
        $this->c = new Connexion("localhost","root","344561","miniProjet_php");
        
        $this->pdo=$this->c->getConnexion();
    }
    public function  liste_medecins(){
        $res=$this->pdo->query('SELECT * FROM Médecin');
        return $res;
    }
}

?>
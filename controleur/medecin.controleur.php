<?php

class Medecin_controleur{
    private $c;
    private $pdo;
    public function __construct(){
        $this->c = new Connexion("localhost","miniprojet","medecin","344561");
        include("modele/pdo.php");
        $this->pdo=$this->c->getConnexion();
    }
    public function  liste_medecins(){
        $res=$this->pdo->query('SELECT * FROM Medecin');
        return $res;
    }
}

?>
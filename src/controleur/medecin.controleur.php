<?php
require('../modele/repository/dao.medecin.php');

class Medecin_controleur{

    private $daoMedecin;

    public function __construct(){
        $this->daoMedecin = new Dao_Medecin();
    }
    public function liste_medecins(){
        return $this->daoMedecin->liste_medecins("","");
    }
    public function ajouter_medecin(string $nom,string $prenom,string $civilite){
        $personne=new Personne($nom,$prenom,$civilite);

        $medecin=new Medecin($personne);
        $this->daoMedecin->ajouter_medecins($medecin);
    }
}

?>
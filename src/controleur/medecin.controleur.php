<?php
require('../modele/repository/dao.medecin.php');

class Medecin_controleur{

    private $daoMedecin;

    public function __construct(){
        $this->daoMedecin = new Dao_Medecin();
        echo "dao est crée";
    }
    public function liste_medecins(){
        return $this->daoMedecin->liste_medecins("","");
    }
}

?>
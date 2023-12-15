<?php
require('../modele/classes/classes.php');
require('../dao/dao.medecin.php');

class Medecin_controleur{

    private $daoMedecin;

    public function __construct(){
        $this->daoMedecin = new DaoMedecin();
    }
}

?>
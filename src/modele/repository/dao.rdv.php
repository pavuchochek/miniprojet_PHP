<?php
include_once('../modele/repository/pdo.php');
include_once('../modele/classes/medecin.class.php');
include_once('../modele/classes/rdv.class.php');
include_once('../modele/repository/dao.usager.php');
class Dao_Rdv{
    private $pdo;

    public function __construct() {
        include_once('../../configuration.php');
        $this->pdo = Connexion::getInstance($db_address, $user, $password, $db_name);
    }
    public function createRdv(){
        
    }
    public function updateRdv(){

    }
    public function liste_rdv_Actuels(){

    }
    public function deleteRdv(){
    }
}
?>
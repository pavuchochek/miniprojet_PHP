<?php 
require('../modele/repository/dao.usager.php');
class Usager_controleur{
        private $daoUsager;
    
        public function __construct() {
            $this->daoUsager=new Dao_Usager();
        }
        public function liste_usagers(){
            return $this->daoUsager->listeUsagers("","");
        }
}
?>
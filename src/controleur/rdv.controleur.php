<?php 
require('/app/src/modele/repository/dao.rdv.php');
class Rdv_controleur{
        private $daoRdv;
    
        public function __construct() {
            $this->daoRdv=new Dao_Rdv();
        }

        public function liste_rdv(){
            return $this->daoRdv->liste_rdv_Actuels();
        }
}
?>
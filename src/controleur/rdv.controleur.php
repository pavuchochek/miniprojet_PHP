<?php 
require('/app/src/modele/repository/dao.rdv.php');
require('/app/src/modele/repository/dao.medecin.php');
class Rdv_controleur{
        private $daoRdv;
        private $daoMedecin;
    
        public function __construct() {
            $this->daoRdv=new Dao_Rdv();
            $this->daoMedecin=new Dao_Medecin();
        }

        public function liste_rdv(){
            return $this->daoRdv->liste_rdv_Actuels();
        }
        public function creationRdv($idMedecin,$idUsager,$date,$heureDebut,$heurefin){
            $usager=$this->daoRdv->getUsagerById($idUsager);
            $medecin=$this->daoMedecin->getMedecinById($idMedecin);
            $rdv=new Rdv($date,$heureDebut,$heurefin,$medecin,$usager);
            $this->daoRdv->createRdv($rdv);
        }
        public function modifierRdv(){
            
        }
}
?>
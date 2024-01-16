<?php 
require('/app/src/modele/repository/dao.rdv.php');
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
        public function modifierRdv($idMedecinAncien,$idUsagerAncien,$dateAncien,$heureDebutAncien,$heurefinAncien,$idMedecin,$idUsager,$date,$heureDebut,$heurefin){
            $this->suppressionRdv($idMedecinAncien, $idUsagerAncien, $dateAncien, $heureDebutAncien,$heurefinAncien) ;
            $this->creationRdv($idMedecin, $idUsager, $date, $heureDebut, $heurefin) ;
        }
        public function suppressionRdv(int $idMedecin,int $idUsager,$date,$heureDebut,$heurefin){
            $usager=$this->daoRdv->getUsagerById($idUsager);
            $medecin=$this->daoMedecin->getMedecinById($idMedecin);
            $rdv=new Rdv($date,$heureDebut,$heurefin,$medecin,$usager);
            $this->daoRdv->deleteRdv($rdv);
        }
        public function getRdvByIdUsager(int $idUsager){
            $array=$this->daoRdv->liste_rdv_Actuels_usagerbyId($idUsager);
            return $array;
        }
        public function getRdvByIdMedecin(int $idMedecin){
            $array=$this->daoRdv->liste_rdv_Actuels_medecinbyId($idMedecin);
            return $array;
        }
        public function getRdvByIdMedecinIdUsager(int $idUsager,int $idMedecin){
            $array=$this->daoRdv->liste_rdv_Actuels_medecin_usager_byId($idUsager,$idMedecin);
            return $array;
        }
}
?>
<?php
require('/app/src/modele/repository/dao.rdv.php');
class Stats_controleur{
        private $daoRdv;
        
        public function __construct() {
            $this->daoRdv=new Dao_Rdv();
        }
        public function getNbHeures(int $idMedecin) {
            $listeRdv = $this->daoRdv->liste_rdv_byMedecin($idMedecin);
            $nbHeures = 0;
            foreach ($listeRdv as $rdv) {
                $nbHeures += $rdv->getDuree();
            }
            return $nbHeures;
        }
    }
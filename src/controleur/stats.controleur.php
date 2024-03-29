<?php
require('/app/src/modele/repository/dao.rdv.php');

class Stats_controleur{
    private $daoRdv;
    private $daoMedecin;
    private $daoUsager;
    
    public function __construct() {
        $this->daoRdv=new Dao_Rdv();
        $this->daoMedecin=new Dao_Medecin();
        $this->daoUsager=new Dao_Usager();
    }
    
    public function getNbHeures(int $idMedecin) {
        $listeRdv = $this->daoRdv->liste_rdv_byMedecin($idMedecin);
        $nbHeures = 0;
        foreach ($listeRdv as $rdv) {
            $nbHeures += $rdv->getDuree();
        }
        return $nbHeures;
    }

    public function getNbHeuresPassee(int $idMedecin) {
        $listeRdv = $this->daoRdv->liste_rdv_byMedecin($idMedecin);
        $nbHeures = 0;
        foreach ($listeRdv as $rdv) {
            if ($rdv->getDateRdv() < date("Y-m-d")) {
                $nbHeures += $rdv->getDuree();
            }
        }
        return $nbHeures;
    }

    public function liste_medecins(){
        return $this->daoMedecin->liste_medecins("","");
    }

    public function getMedecinById(int $idMedecin) {
        return $this->daoMedecin->getMedecinById($idMedecin);
    }

    public function liste_usagers(){
        return $this->daoUsager->listeUsagers();
    }
}
<?php
require('/app/src/modele/repository/dao.medecin.php');

class Medecin_controleur{
    private $daoMedecin;

    public function __construct() {
        $this->daoMedecin=new Dao_Medecin();
    }

    public function liste_medecins(){
        return $this->daoMedecin->liste_medecins("","");
    }

    public function ajouter_medecin(string $nom,string $prenom,string $civilite){
        $personne=new Personne($nom,$prenom,$civilite);
        $medecin=new Medecin($personne);
        $this->daoMedecin->ajouter_medecins($medecin);
    }

    public function rechercherMedecins($recherche) {
        $listeMedecins = $this->liste_medecins();
        $resultats = array_filter($listeMedecins, function ($medecin) use ($recherche) {
            $nomPrenom = strtolower($medecin->getNom() . ' ' . $medecin->getPrenom());
            return strpos($nomPrenom, $recherche) !== false;
        });
        return $resultats;
    }

    public function modifier_medecin(string $nom,string $prenom,string $civilite,int $idMedecin){
        $medecin = $this->daoMedecin->getMedecinById($idMedecin);
        $this->daoMedecin->modifier_medecins($medecin,$nom,$prenom, $civilite);
    }
    
    public function supprimer_medecin(int $idMedecin){
        $medecin = $this->daoMedecin->getMedecinById($idMedecin);
        $this->daoMedecin->supprimer_medecins($medecin);
    }

    public function getIdMedecinByPrenomNom($prenom, $nom) {
        return $this->daoMedecin->getIdMedecinByPrenomNom($prenom, $nom);
    }

    public function getMedecinById($idMedecin) {
        return $this->daoMedecin->getMedecinById($idMedecin);
    }

    public function getListeUsagersMedecin(int $idMedecin){
        $medecin = $this->daoMedecin->getMedecinById($idMedecin);
        return $this->daoMedecin->liste_usager_medecin($medecin);
    }

    public function getListeRdv(int $idMedecin){
        $medecin = $this->daoMedecin->getMedecinById($idMedecin);
        return $this->daoMedecin->liste_rdv_actuel($medecin);
    }

    public function rechercherUsagersMedecin($recherche, int $idMedecin) {
        $listeUsagers = $this->getListeUsagersMedecin($idMedecin);
        $resultats = array_filter($listeUsagers, function ($usager) use ($recherche) {
            $nomPrenom = strtolower($usager->getNom() . ' ' . $usager->getPrenom());
            return strpos($nomPrenom, $recherche) !== false;
        });
        return $resultats;
    }
    
    public function listeUsagersNonReferents(int $idMedecin){
        $listeUsagers =$this->daoMedecin->liste_usagers_medecin_non_referent($idMedecin);
        return $listeUsagers;
    }

    public function getListeUsagers() {
        return $this->daoMedecin->getListeUsagers();
    }
}

?>
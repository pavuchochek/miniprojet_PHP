<?php 
require('/app/src/modele/repository/dao.usager.php');
class Usager_controleur{
        private $daoUsager;
    
        public function __construct() {
            $this->daoUsager=new Dao_Usager();
        }
        public function liste_usagers(){
            return $this->daoUsager->listeUsagers();
        }
        public function rechercherUsagers($recherche) {
            $listeUsagers = $this->daoUsager->listeUsagers();
            $resultats = array_filter($listeUsagers, function ($usager) use ($recherche) {
                $nomPrenom = strtolower($usager->getNom() . ' ' . $usager->getPrenom());
                return strpos($nomPrenom, $recherche) !== false;
            });
            return $resultats;
        }

        public function ajouter_usager(string $nom,string $prenom,string $civilite,string $adresse,string $dateNaissance,string $lieuNaissance,int $Numero_Secu,?int $idMedecin){
            $personne=new Personne($nom,$prenom,$civilite);
            $medecinReferent=$this->daoUsager->getMedecinById($idMedecin);
            $usager=new Usager($personne, $Numero_Secu, $adresse, $dateNaissance, $lieuNaissance, $medecinReferent);
            $this->daoUsager->addUsager($usager);
        }
}
?>
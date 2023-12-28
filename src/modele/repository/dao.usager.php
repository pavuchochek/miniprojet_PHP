<?php
include_once('../modele/repository/pdo.php');
include_once('../controleur/medecin.controleur.php');
include_once('../modele/classes/usager.class.php');
define('LOG_FILE', 'logs.log');



class Dao_Usager{
    
    private $c;
    private $pdo;
    private $daoMedecin;
    public function __construct(){
        include_once('../../configuration.php');
        $this->c = new Connexion($db_address,$user,$password,$db_name);
        $this->pdo=$this->c->getConnexion();
        $this->daoMedecin = new Dao_Medecin();
    }   

    public function getUsagerById(int $idUsager):Usager{
        try{
            $resUsager = $this->pdo->prepare('SELECT Personne.Nom,Personne.Prenom,Personne.Civilite,Usager.N_securite_sociale,
            Usager.Adresse,Usager.Date_naissance,Usager.Lieu_naissance,Usager.Id_Personne,Usager.Id_Medecin,Usager.Id_Usager
            FROM Usager,Personne WHERE Usager.Id_Personne=Personne.Id_Personne AND Usager.Id_Usager=:id');
            $resUsager->execute(array(
                'id' => $idUsager
            ));
            $dataUsager = $resUsager->fetch();
            if (!$dataUsager) {
                throw new Exception("Aucun usager trouvé avec l'ID : $idUsager");
            }
            $personne = new Personne($dataUsager[0], $dataUsager[1], $dataUsager[2]);
            $personne->setId($dataUsager[7]);
            if(!is_null($dataUsager[8])){
                $medecin=$this->daoMedecin->getMedecinById($dataUsager[8]);
            }else{
                $medecin=null;
            }
            $usager = new Usager($personne, $dataUsager[3], $dataUsager[4],$dataUsager[5],$dataUsager[6],$medecin);
            $usager->setIdUsager($dataUsager[9]);

            return $usager;
        }catch (PDOException $e) {
            // En cas d'erreur, afficher le message d'erreur
            error_log("Error executing SQL query: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
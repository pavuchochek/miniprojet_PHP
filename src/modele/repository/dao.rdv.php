<?php
require_once('/app/src/modele/repository/pdo.php');
require_once('/app/src/modele/classes/medecin.class.php');
require_once('/app/src/modele/classes/rdv.class.php');
require_once('/app/src/modele/repository/dao.usager.php');
class Dao_Rdv{
    private $pdo;

    public function __construct() {
        include('/app/configuration.php');
        $this->pdo = Connexion::getInstance($db_address, $user, $password, $db_name);
    }

    public function createRdv(Rdv $rdv){
        try {
            $req = $this->pdo->prepare('INSERT INTO Rdv (Id_Usager,Id_Medecin,Date_rdv,Heure_debut,Heure_fin) VALUES (:usager,:medecin,:daterdv,:hd,:hf)');
            $idusager = $rdv->getUsager()->getIdUsager();
            $idmedecin = $rdv->getMedecin() -> getIdMedecin();
            $req->execute(array(
                'usager' => $idusager,
                'medecin' => $idmedecin,
                'daterdv' => $rdv->getDateRdv(),
                'hd' => $rdv->getHeureDebut(),
                'hf' => $rdv->getHeureFin()
            ));
        }catch(PDOException $e){
            throw $e;
        }
    }
    public function creneauDisponibleMedecin($date, $heureDebut, $heureFin, $idMedecin) {
        try {
            $conditions = array(
                'date' => $date,
                'heureDebut' => $heureDebut,
                'heureFin' => $heureFin,
                'idMedecin' => $idMedecin
            );
    
            $query = 'SELECT COUNT(*) FROM Rdv WHERE Date_rdv = :date AND ((Heure_Debut >= :heureDebut AND Heure_Debut < :heureFin) OR (Heure_Fin > :heureDebut AND Heure_Fin <= :heureFin)) AND Id_Medecin = :idMedecin';
    
            $resRDV = $this->pdo->prepare($query);
            $resRDV->execute($conditions);
    
            $count = $resRDV->fetchColumn();
    
            return $count === 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }
    
    public function creneauDisponibleUsager($date, $heureDebut, $heureFin, $idUsager) {
        try {
            $conditions = array(
                'date' => $date,
                'heureDebut' => $heureDebut,
                'heureFin' => $heureFin,
                'idUsager' => $idUsager
            );
    
            $query = 'SELECT COUNT(*) FROM Rdv WHERE Date_rdv = :date AND ((Heure_Debut >= :heureDebut AND Heure_Debut < :heureFin) OR (Heure_Fin > :heureDebut AND Heure_Fin <= :heureFin)) AND Id_Usager = :idUsager';
    
            $resRDV = $this->pdo->prepare($query);
            $resRDV->execute($conditions);
    
            $count = $resRDV->fetchColumn();
    
            return $count === 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }
    
    

    public function modifier_medecins(Rdv $ancienRdv,Rdv $nouveauRdv){
        //suppression de l'ancien rdv
        $this->deleteRdv($ancienRdv);
        //recreation du rdv
        $this->createRdv($nouveauRdv);
    }

    private function constructRdvFromData($data){
        $usager=$this->getUsagerById($data[0]);
        $medecin=$this->getMedecinById($data[1]);
        $rdv=new Rdv($data[2],$data[3],$data[4],$medecin,$usager);
        return $rdv;
        
    }

    public function getListeUsagersRdv(){
        $resRDV = $this->pdo->prepare('SELECT DISTINCT Id_Usager FROM Rdv WHERE Date_rdv>=CURDATE();');
        $resRDV->execute();
        $tablo_usager=array();
        while ($data = $resRDV->fetch()) {
            $usager=$this->getUsagerById($data[0]);
            $tablo_usager[]=$usager;
        }
        return $tablo_usager;
    }

    public function getListeMedecinsRdv(){
        $resRDV = $this->pdo->prepare('SELECT DISTINCT Id_Medecin FROM Rdv WHERE Date_rdv>=CURDATE();');
        $resRDV->execute();
        $tablo_medecins=array();
        while ($data = $resRDV->fetch()) {
            $usager=$this->getMedecinById($data[0]);
            $tablo_medecins[]=$usager;
        }
        return $tablo_medecins;
    }

    public function liste_rdv_Actuels(){
        $resRDV = $this->pdo->prepare('SELECT Id_Usager,Id_medecin,Date_rdv,Heure_Debut,Heure_Fin FROM Rdv WHERE Date_rdv>=CURDATE() order by Date_rdv,Heure_Debut');
        $resRDV->execute();
        $tablo_rdv=array();
        while ($data = $resRDV->fetch()) {
            $rdv=$this->constructRdvFromData($data);
            $tablo_rdv[]=$rdv;
        }
        return $tablo_rdv;
    }

    public function liste_rdv_Actuels_medecinbyId(int $idMedecin){
        $resRDV = $this->pdo->prepare('SELECT Id_Usager,Id_medecin,Date_rdv,Heure_Debut,Heure_Fin FROM Rdv WHERE Date_rdv>=CURDATE() AND Id_medecin = :id') ;
        $resRDV->execute(array(
            'id' => $idMedecin
        ));
        $tablo_rdv=array();
        while ($data = $resRDV->fetch()) {
            $rdv=$this->constructRdvFromData($data);
            $tablo_rdv[]=$rdv;
        }
        return $tablo_rdv;
    }

    public function liste_rdv_Actuels_usagerbyId(int $idUsager){
        $resRDV = $this->pdo->prepare('SELECT Id_Usager,Id_medecin,Date_rdv,Heure_Debut,Heure_Fin FROM Rdv WHERE Date_rdv>=CURDATE() AND Id_Usager = :id') ;
        $resRDV->execute(array(
            'id' => $idUsager
        ));
        $tablo_rdv=array();
        while ($data = $resRDV->fetch()) {
            $rdv=$this->constructRdvFromData($data);
            $tablo_rdv[]=$rdv;
        }
        return $tablo_rdv;
    }

    /* FORMAT DE DATES YYYY-MM-DD */
    public function liste_rdv_Actuels_date(String $date){
        $resRDV = $this->pdo->prepare('SELECT Id_Usager,Id_medecin,Date_rdv,Heure_Debut,Heure_Fin FROM Rdv WHERE Date_rdv= :dateSelection') ;
        $resRDV->execute(array(
            'dateSelection' => $date
        ));
        $tablo_rdv=array();
        while ($data = $resRDV->fetch()) {
            $rdv=$this->constructRdvFromData($data);
            $tablo_rdv[]=$rdv;
        }
        return $tablo_rdv;
    }

    public function liste_rdv_Actuels_Intervalle(String $dateDebut,String $dateFin){
        $resRDV = $this->pdo->prepare('SELECT Id_Usager,Id_medecin,Date_rdv,Heure_Debut,Heure_Fin FROM Rdv WHERE Date_rdv BETWEEN  :dateDebut AND :dateFin') ;
        $resRDV->execute(array(
            'dateDebut' => $dateDebut,
            'dateFin'=>$dateFin
        ));

    }

    public function liste_rdv_byMedecin(int $idMedecin){
        $resRDV = $this->pdo->prepare('SELECT Id_Usager,Id_medecin,Date_rdv,Heure_Debut,Heure_Fin FROM Rdv WHERE Id_medecin = :idMedecin') ;
        $resRDV->execute(array(
            'idMedecin' => $idMedecin
        ));
        $tablo_rdv=array();
        while ($data = $resRDV->fetch()) {
            $rdv=$this->constructRdvFromData($data);
            $tablo_rdv[]=$rdv;
        }
        return $tablo_rdv;
    }

    public function liste_rdv_Actuels_medecin_usager_byId(int $idUsager,int $idMedecin){
        $resRDV = $this->pdo->prepare('SELECT Id_Usager,Id_medecin,Date_rdv,Heure_Debut,Heure_Fin FROM Rdv WHERE Id_medecin = :idMedecin AND Id_usager = :idUsager') ;
        $resRDV->execute(array(
            'idMedecin' => $idMedecin,
            'idUsager' => $idUsager
        ));
        $tablo_rdv=array();
        while ($data = $resRDV->fetch()) {
            $rdv=$this->constructRdvFromData($data);
            $tablo_rdv[]=$rdv;
        }
        return $tablo_rdv;
    }
    public function deleteRdv(Rdv $rdv){
        try{
        $resRDV = $this->pdo->prepare('DELETE FROM Rdv WHERE Id_Medecin = :idMedecin AND Id_Usager = :idUsager AND Date_rdv = :daterdv AND Heure_debut = :hd AND Heure_fin = :hf') ;
        $resRDV->execute(array(
            'idMedecin' => $rdv->getMedecin()->getIdMedecin(),
            'idUsager' => $rdv->getUsager()->getIdUsager(),
            'daterdv' => $rdv ->getDateRdv(),
            'hd' => $rdv->getHeureDebut(),
            'hf' => $rdv->getHeureFin()
        ));
         }catch(PDOException $e){
        throw $e;
        }
    }
    
    public function getUsagerById(int $idUsager): Usager {
        try {
            $resUsager = $this->pdo->prepare('
                SELECT Personne.Nom, Personne.Prenom, Personne.Civilite,
                       Usager.N_securite_sociale, Usager.Adresse, Usager.Date_naissance,
                       Usager.Lieu_naissance, Usager.Id_Personne, Usager.Id_Medecin, Usager.Id_Usager
                FROM Usager
                JOIN Personne ON Usager.Id_Personne = Personne.Id_Personne
                WHERE Usager.Id_Usager = :id
            ');
            $resUsager->execute(array(
                'id' => $idUsager
            ));
            $dataUsager = $resUsager->fetch();
    
            if (!$dataUsager) {
                throw new Exception("Aucun usager trouvé avec l'ID : $idUsager");
            }else{
            if(!is_null($dataUsager[8])){
                $medecin = $this->getMedecinById($dataUsager[8]);
            }else{
                $medecin=null;
            }
               
    
            // Création de l'objet Usager
            $personne = new Personne($dataUsager[0], $dataUsager[1], $dataUsager[2]);
            $personne->setId($dataUsager[7]);
            $usager = new Usager(
                $personne,
                $dataUsager['N_securite_sociale'],
                $dataUsager['Adresse'],
                $dataUsager['Date_naissance'],
                $dataUsager['Lieu_naissance'],
                $medecin
            );
            $usager->setIdUsager($dataUsager['Id_Usager']);
            }
    
            // Récupération des informations du médecin associé
            
    
            return $usager;
        } catch (PDOException $e) {
            // En cas d'erreur, afficher le message d'erreur
            error_log("Error executing SQL query: " . $e->getMessage());
            throw $e;
        }
    }
    
    private function getMedecinById(int $idMedecin): ?Medecin {
        try {
            $req = $this->pdo->prepare('
                SELECT Personne.Nom, Personne.Prenom, Personne.Civilite, Personne.Id_Personne
                FROM Medecin
                JOIN Personne ON Medecin.Id_Personne = Personne.Id_Personne
                WHERE Medecin.Id_Medecin = :id
            ');
    
            $req->execute(array(
                'id' => $idMedecin
            ));
    
            $data = $req->fetch();
    
            if (!$data) {
                return null; // Aucun médecin trouvé avec l'ID : $idMedecin
            }
    
            // Création de l'objet Medecin
            $personne = new Personne($data['Nom'], $data['Prenom'], $data['Civilite']);
            $personne->setId($data['Id_Personne']);
            $medecin = new Medecin($personne);
            $medecin->setIdMedecin($idMedecin);
    
            return $medecin;
        } catch (PDOException $e) {
            // En cas d'erreur, afficher le message d'erreur
            error_log("Error executing SQL query: " . $e->getMessage());
            throw $e;
        }
    }
    
}
?>
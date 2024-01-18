<?php
include_once('personne.class.php');

class Usager extends Personne{

	private $_IdUsager;
	private $_N_sécurite_sociale;
	private $_Adresse;
	private $_Date_naissance;
	private $_Lieu_naissance;
	private $_Medecin_referent;
	
	//Constructeur
	public function __construct(Personne $personne,int $NSecuSociale,String $Adresse,String $Date_naissance, String $Lieu_naissance, ?Medecin $medecin) {
		parent::__construct($personne->getNom(), $personne->getPrenom(), $personne->getCivilite());
		$this->_N_sécurite_sociale= $NSecuSociale;
		$this->_Adresse = $Adresse;
		$this->_Date_naissance = $Date_naissance;
		$this->_Medecin_referent = $medecin;
		$this->_Lieu_naissance = $Lieu_naissance;
		$this->setId($personne->getId());
	}

	//Retourne l'adresse de l'usager
	public function getAdresse():String{
		return $this->_Adresse;
	}

	//Retourne l'id de l'usager
	public function getIdUsager():int{
		return $this->_IdUsager;
	}

	//Retourne l'id de l'usager
	public function setIdUsager(int $idUsager): void{
		$this->_IdUsager = $idUsager;
	}

	//Retourne la date de naissance de l'usager
	public function getDateNaissance():String{
		return $this->_Date_naissance;
	}

	//Retourne le médecin référent de l'usager
	public function getMedecinReferent():?Medecin{
		return $this->_Medecin_referent;
	}

	//Retourne le lieu de naissance de l'usager
	public function getLieuNaissance():String{
		return $this->_Lieu_naissance;
	}

	//Retourne le numéro de sécurité sociale de l'usager
	public function getNsecuriteSociale():String{
		return $this->_N_sécurite_sociale;
	}

	//Modifie l'adresse de l'usager
	public function setAdresse(String $Adresse){
		$this->_Adresse = $Adresse;
	}

	//Modifie la date de naissance de l'usager
	public function setDateNaissance(String $Date_naissance){
		$this->_Date_naissance = $Date_naissance;
	}

	//Modifie le médecin référent de l'usager
	public function setMedecinReferent(Medecin $Medecin_referent){
		$this->_Medecin_referent = $Medecin_referent;
	}

	//Modifie le lieu de naissance de l'usager
	public function setLieuNaissance(String $Lieu_naissance){
		$this->_Lieu_naissance = $Lieu_naissance;
	}

	//Modifie le numéro de sécurité sociale de l'usager
	public function setNsecuriteSociale(String $N_sécurite_sociale){
		$this->_N_sécurite_sociale = $N_sécurite_sociale;
	}

	//Retourne l'âge de l'usager
	public function getAge():int {
		$age = date_diff(date_create($this->_Date_naissance), date_create('today'))->y;
		return $age;
	}
}
?>
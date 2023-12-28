<?php

include_once('../modele/classes/personne.class.php');
class Usager extends Personne{
	private $_IdUsager;
	private $_N_sécurite_sociale;
	private $_Adresse;
	private $_Date_naissance;
	private $_Lieu_naissance;
	private $_Medecin_referent;
	
	public function __construct(Personne $personne,String $Adresse,String $Date_naissance, String $Lieu_naissance, Medecin $medecin)
	{
		parent::__construct($personne->getNom(), $personne->getPrenom(), $personne->getCivilite());
		$this->_Adresse = $Adresse;
		$this->_Date_naissance = $Date_naissance;
		$this->_Medecin_referent = $medecin;
		$this->_Lieu_naissance = $Lieu_naissance;
		$this->setId($personne->getId());
	}

	public function getAdresse():String{
		return $this->_Adresse;
	}
	public function getIdUsager():int{
		return $this->_IdUsager;
	}
	public function setIdUsager(int $idUsager): void{
		$this->_IdUsager = $idUsager;
	}
	public function getDateNaissance():String{
		return $this->_Date_naissance;
	}

	public function getMedecinReferent():Medecin{
		return $this->_Medecin_referent;
	}

	public function getLieuNaissance():String{
		return $this->_Lieu_naissance;
	}

	public function getNsecuriteSociale():String{
		return $this->_N_sécurite_sociale;
	}

	public function setAdresse(String $Adresse){
		$this->_Adresse = $Adresse;
	}

	public function setDateNaissance(String $Date_naissance){
		$this->_Date_naissance = $Date_naissance;
	}

	public function setMedecinReferent(Medecin $Medecin_referent){
		$this->_Medecin_referent = $Medecin_referent;
	}

	public function setLieuNaissance(String $Lieu_naissance){
		$this->_Lieu_naissance = $Lieu_naissance;
	}

	public function setNsecuriteSociale(String $N_sécurite_sociale){
		$this->_N_sécurite_sociale = $N_sécurite_sociale;
	}
}
?>
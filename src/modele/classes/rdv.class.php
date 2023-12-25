<?php
class Rdv{
	private $_Date_rdv;
	private $_Heure_début;
	private $_Heure_fin;
	private $_Medecin;
	private $_Usager;
	
	public function __construct($Date_rdv, $Heure_début, $Heure_fin, $Medecin, $Usager)
	{
		$this->_Date_rdv = $Date_rdv;
		$this->_Heure_début = $Heure_début;
		$this->_Heure_fin = $Heure_fin;
		$this->_Medecin = $Medecin;
		$this->_Usager = $Usager;
	}

	public function getDateRdv():String{
		return $this->_Date_rdv;
	}

	public function getHeureDebut():String{
		return $this->_Heure_début;
	}

	public function getHeureFin():String{
		return $this->_Heure_fin;
	}

	public function getMedecin():Medecin{
		return $this->_Medecin;
	}

	public function getUsager():Usager{
		return $this->_Usager;
	}

	public function setDateRdv(String $Date_rdv){
		$this->_Date_rdv = $Date_rdv;
	}

	public function setHeureDebut(String $Heure_début){
		$this->_Heure_début = $Heure_début;
	}

	public function setHeureFin(String $Heure_fin){
		$this->_Heure_fin = $Heure_fin;
	}

	public function setMedecin(Medecin $Medecin){
		$this->_Medecin = $Medecin;
	}
	
	public function setUsager(Usager $Usager){
		$this->_Usager = $Usager;
	}


}
?>
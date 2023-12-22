<?php

include_once('../modele/classes/personne.class.php');
class Usager extends Personne{
	private $_N_sécurite_sociale;
	private $_Adresse;
	private $_Date_naissance;
	private $_Lieu_naissance;
	private $_Medecin_referent;
	
	public function __construct(string $Nom, string $Prenom, String $Civilite, Personne $personne,String $Adresse,String $Date_naissance, String $Lieu_naissance, Medecin $medecin)
	{
		parent::__construct($Nom, $Prenom, $Civilite);
		$this->_Adresse = $Adresse;
		$this->_Date_naissance = $Date_naissance;
		$this->_Medecin_referent = $medecin;
		$this->_Lieu_naissance = $Lieu_naissance;
	}
}
?>
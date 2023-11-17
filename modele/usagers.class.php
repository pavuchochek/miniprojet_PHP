<?php
class Usager extends Personne{
	private $_Id_Usager;
	private $_N_sécurite_sociale;
	private $_Adresse;
	private $_Date_naissance;
	private $_Lieu_naissance;
	private $_Id_Medecin_referent;
	
	public function __construct($Id_Usager, string $Nom, string $Prenom, Civilite $Civilite, int $Id_personne, $Id_medecin, $Adresse, $Date_naissance, $Lieu_naissance, $Id_Medecin_referent)
	{
		super($Nom, $Prenom, $Civilite, $Id_personne);
		$this->_Adresse = $Adresse;
		$this->_Date_naissance = $Date_naissance;
		$this->_Id_Usager = $Id_Usager;
		$this->_Id_Medecin_referent = $Id_Medecin_referent;
		$this->_Lieu_naissance = $Lieu_naissance;
		$this->_N_sécurite_sociale = $N_sécurite_sociale;
	}
}
?>
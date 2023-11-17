<?php
class Usager{
	private $_Id_Usager;
	private $_Id_personne;
	private $_N_sécurite_sociale;
	private $_Adresse;
	private $_Date_naissance;
	private $_Lieu_naissance;
	private $_Id_Medecin_referent;
	
	public function __construct($Id_Usager, $Id_personne, $Id_medecin, $Adresse, $Date_naissance $Lieu_naissance, $Id_Medecin_referent)
	{
		$this->_Id_personne = $Id_personne;
		$this->_Adresse = $Adresse;
		$this->_Date_naissance = $Date_naissance;
		$this->_Id_Usager = $Id_Usager;
		$this->_Id_Medecin_referent = $Id_Medecin_referent;
		$this->_Lieu_naissance = $Lieu_naissance;
		$this->_Id_medecin = $Id_medecin;
	}
}
?>
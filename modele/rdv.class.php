<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/miniProjet_php/modele/classes.php');
class Rdv{
	private $_Id_Rdv;
	private $_Date_rdv;
	private $_Heure_début;
	private $_Heure_fin;
	private $_Id_Medecin;
	private $_Id_Usager;
	
	public function __construct($Id_Rdv, $Date_rdv, $Heure_début, $Heure_fin, $Id_Medecin, $Id_Usager)
	{
		$this->_Id_Rdv = $Id_Rdv;
		$this->_Date_rdv = $Date_rdv;
		$this->_Heure_début = $Heure_début;
		$this->_Heure_fin = $Heure_fin;
		$this->_Id_Medecin = $Id_Medecin;
		$this->_Id_Usager = $Id_Usager;
	}
}
?>
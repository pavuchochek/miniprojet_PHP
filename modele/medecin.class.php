<?php
class Medecin extends Personne{

	private $_Id_medecin;
	
	public function __construct(string $Nom, string $Prenom, Civilite $Civilite, int $Id_personne, int $Id_medecin)
	{
		parent::__construct($Nom, $Prenom, $Civilite, $Id_personne);
		$this->_Id_medecin = $Id_medecin;
	}
	
	public function getIdMedecin(): int
	{
		return $this->_Id_medecin;
	}
}
?>
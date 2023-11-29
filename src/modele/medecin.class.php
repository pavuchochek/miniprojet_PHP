<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/miniProjet_php/src/modele/personne.class.php');

class Medecin extends Personne{

	private $_Id_medecin;
	
		public function __construct(string $Nom, string $Prenom, string $Civilite, int $Id_personne, int $Id_medecin)
		{
			parent::__construct($Nom, $Prenom, $Civilite, $Id_personne);
			$this->_Id_medecin = $Id_medecin;
		}
		
		public function getIdMedecin(): int
		{
			return $this->_Id_medecin;
		}

		public function setIdMedecin(int $Id_medecin): void
		{
			$this->_Id_medecin = $Id_medecin;
		}

		public function toString(): string
		{
			return "Id_medecin : ".$this->getIdMedecin().parent::toString();
		}
	}
	?>

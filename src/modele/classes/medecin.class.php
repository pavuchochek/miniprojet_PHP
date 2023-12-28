<?php
include_once('personne.class.php');

class Medecin extends Personne{

	private $_Id_medecin;
	
		public function __construct(Personne $personne)
		{
			parent::__construct($personne->getNom(), $personne->getPrenom(), $personne->getCivilite());
			$this->setId($personne->getId()); 
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

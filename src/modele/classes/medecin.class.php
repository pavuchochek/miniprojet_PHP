<?php
include_once('personne.class.php');

class Medecin extends Personne{

	private $_Id_medecin;
	
	//Constructeur
	public function __construct(Personne $personne) {
		parent::__construct($personne->getNom(), $personne->getPrenom(), $personne->getCivilite());
		$this->setId($personne->getId()); 
	}
	
	//Retourne l'id du medecin
	public function getIdMedecin(): int {
		return $this->_Id_medecin;
	}

	//Modifie l'id du medecin
	public function setIdMedecin(int $Id_medecin): void {
		$this->_Id_medecin = $Id_medecin;
	}

	//Retourne les nom et prénom du medecin en String
	public function toString(): string {
		return $this->getNom()." ".$this->getPrenom();
	}
}
?>

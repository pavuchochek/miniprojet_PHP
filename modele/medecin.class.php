<?php
class Medecin{
	private $_Id_medecin;
	private $_Id_personne;
	
	public function __construct($Personne, $Id_medecin)
	{
		$this->_Personne = $Personne;
		$this->_Id_medecin = $Id_medecin;
	}
	
	public function getName(): string
    {
        return $this->name;
    }
}
?>
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

	public function getJourSemaine():String{
		$date = $this->_Date_rdv;
		
		$englishDays = [
			'Monday'    => 'Lundi',
			'Tuesday'   => 'Mardi',
			'Wednesday' => 'Mercredi',
			'Thursday'  => 'Jeudi',
			'Friday'    => 'Vendredi',
			'Saturday'  => 'Samedi',
			'Sunday'    => 'Dimanche',
		];
	
		$formattedDate = $englishDays[date('l', strtotime($date))];
		
		return $formattedDate;
	}

	public function getDateRdvString(): String {
		$date = $this->_Date_rdv;
		
		$englishMonths = [
			'January'   => 'Janvier',
			'February'  => 'Février',
			'March'     => 'Mars',
			'April'     => 'Avril',
			'May'       => 'Mai',
			'June'      => 'Juin',
			'July'      => 'Juillet',
			'August'    => 'Août',
			'September' => 'Septembre',
			'October'   => 'Octobre',
			'November'  => 'Novembre',
			'December'  => 'Décembre',
		];
	
		$formattedDate = date('d ') . $englishMonths[date('F', strtotime($date))] . date(' Y', strtotime($date));
		
		return $formattedDate;
	}

	public function getMois3lettres(): String {
		$date = $this->_Date_rdv;
		
		$englishMonths = [
			'January'   => 'Jan',
			'February'  => 'Fév',
			'March'     => 'Mar',
			'April'     => 'Avr',
			'May'       => 'Mai',
			'June'      => 'Juin',
			'July'      => 'Juil',
			'August'    => 'Août',
			'September' => 'Sept',
			'October'   => 'Oct',
			'November'  => 'Nov',
			'December'  => 'Déc',
		];
	
		$formattedDate = $englishMonths[date('F', strtotime($date))];
		
		return $formattedDate;
	}

	public function getNuméroJour(): String {
		$date = $this->_Date_rdv;
		
		$formattedDate = date('d', strtotime($date));
		
		return $formattedDate;
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
	public function getDuree(): float {
		// Convertir les heures de début et de fin en minutes
		$heureDebutMinutes = $this->convertirHeureEnMinutes($this->_Heure_début);
		$heureFinMinutes = $this->convertirHeureEnMinutes($this->_Heure_fin);
	
		// Calculer la différence en minutes
		$differenceEnMinutes = $heureFinMinutes - $heureDebutMinutes;
	
		// Convertir la différence en heures décimales
		$dureeEnHeures = $differenceEnMinutes / 60;
	
		return $dureeEnHeures;
	}
	
	private function convertirHeureEnMinutes($heure): int {
		list($heures, $minutes) = explode(':', $heure);
		return ($heures * 60) + $minutes;
	}
	
	
	public function setMedecin(Medecin $Medecin){
		$this->_Medecin = $Medecin;
	}
	
	public function setUsager(Usager $Usager){
		$this->_Usager = $Usager;
	}
}
?>
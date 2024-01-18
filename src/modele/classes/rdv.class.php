<?php

class Rdv{
	
	private $_Date_rdv;
	private $_Heure_début;
	private $_Heure_fin;
	private $_Medecin;
	private $_Usager;
	
	//Constructeur
	public function __construct($Date_rdv, $Heure_début, $Heure_fin, $Medecin, $Usager) {
		$this->_Date_rdv = $Date_rdv;
		$this->_Heure_début = $Heure_début;
		$this->_Heure_fin = $Heure_fin;
		$this->_Medecin = $Medecin;
		$this->_Usager = $Usager;
	}

	//Retourne la date du rdv
	public function getDateRdv():String{ 
		return $this->_Date_rdv;
	}

	//Retourne le jour de la semaine en français
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

	//Retourne la date du rdv en français
	public function getDateRdvString(): string {
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
		$formattedDate = date('d', strtotime($date)) . ' ' . $englishMonths[date('F', strtotime($date))] . date(' Y', strtotime($date));
		return $formattedDate;
	}

	//Retourne le mois en 3 lettres (pour l'affichage dans rdv.php)
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

	//Retourne le numéro du jour
	public function getNuméroJour(): String {
		$date = $this->_Date_rdv;
		
		$formattedDate = date('d', strtotime($date));
		
		return $formattedDate;
	}

	//Retourne le numéro du mois
	public function getAnnee(): String {
		$date = $this->_Date_rdv;
		$formattedDate = date('Y', strtotime($date));
		return $formattedDate;
	}

	//Retourne l'heure de début du rdv
	public function getHeureDebut():String{
		return $this->_Heure_début;
	}

	//Retourne l'heure de fin du rdv
	public function getHeureFin():String{
		return $this->_Heure_fin;
	}

	//Retourne le médecin du rdv
	public function getMedecin():Medecin{
		return $this->_Medecin;
	}

	//Retourne l'usager du rdv
	public function getUsager():Usager{
		return $this->_Usager;
	}

	//Modifie la date du rdv
	public function setDateRdv(String $Date_rdv){
		$this->_Date_rdv = $Date_rdv;
	}

	//Modifie l'heure de début du rdv
	public function setHeureDebut(String $Heure_début){
		$this->_Heure_début = $Heure_début;
	}

	//Modifie l'heure de fin du rdv
	public function setHeureFin(String $Heure_fin){
		$this->_Heure_fin = $Heure_fin;
	}

	//Retourne la durée du rdv (pour la page statistiques.php)
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
	
	// Convertir une heure au format HH:MM en minutes
	private function convertirHeureEnMinutes($heure): int {
		list($heures, $minutes) = explode(':', $heure);
		return ($heures * 60) + $minutes;
	}
	
	//Modifie le médecin du rdv
	public function setMedecin(Medecin $Medecin){
		$this->_Medecin = $Medecin;
	}
	
	//Modifie l'usager du rdv
	public function setUsager(Usager $Usager){
		$this->_Usager = $Usager;
	}
}
?>
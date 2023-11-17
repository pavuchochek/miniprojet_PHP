<?php
enum Civilite{
	case H;
	case F;
}

#Classe de composition (conseil de M. Gaetan Piqué)
class Personne{
	private int $_Id_personne;
	private string $_Nom;
	private string $_Prenom;
	private Civilite $_Civilite;
	
	public function __construct(string $Nom, string $Prenom, Civilite $Civilite, int $Id_personne)
	{
		$this->_Nom = $Nom;
		$this->_Prenom = $Prenom;
		$this->_Civilite = $Civilite;
		$this->_Id_personne = $Id_personne;
	}
	
	public function getNom(): string
    {
        return $this->_Nom;
    }
	
	public function getPrenom(): string
    {
        return $this->_Prenom;
    }
	
	public function getCivilite(): Civilite
    {
        return $this->_Civilite;
    }
	
	public function getId(): int
    {
        return $this->_Id_personne;
    }
	
	public function setNom(string $Nom): void
    {
        $this->_Nom = $Nom;
    }
	
	public function setPrenom(string $Prenom): void
    {
        $this->_Prenom = $Prenom;
    }
	
	public function setCivilite(Civilite $Civilite): void
    {
        $this->_Civilite = $Civilite;
    }
}

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
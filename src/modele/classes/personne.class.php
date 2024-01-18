<?php

#Classe de composition (conseil de M. Gaetan Piqué)
class Personne{
    
    private $_Id_Personne;
    private string $_Nom;
    private string $_Prenom;
    private string $_Civilite;
    
    //Constructeur
    public function __construct(string $Nom, string $Prenom, string $Civilite) {       
        $this->_Nom = $Nom;
        $this->_Prenom = $Prenom;
        $this->_Civilite = $Civilite;
        $this->_Id_Personne = null;
    }
    
    //Retourne le nom de la personne
    public function getNom(): string {
        return $this->_Nom;
    }
    
    //Retourne le prénom de la personne
    public function getPrenom(): string {
        return $this->_Prenom;
    }
    
    //Retourne la civilité de la personne
    public function getCivilite(): string {
        return $this->_Civilite;
    }
    
    //Retourne l'id de la personne
    public function getId(): int {
        if (is_null($this->_Id_Personne)) {
            return 0;
        } else {
            return $this->_Id_Personne; 
        }
    }

    //Modifie l'id de la personne
    public function setId(int $id): void {
        $this->_Id_Personne = (int)$id;
    }
    
    //Modifie le nom de la personne
    public function setNom(string $Nom): void {
        $this->_Nom = $Nom;
    }
    
    //Modifie le prénom de la personne
    public function setPrenom(string $Prenom): void {
        $this->_Prenom = $Prenom;
    }
    
    //Modifie la civilité de la personne
    public function setCivilite(string $Civilite): void {
        $this->_Civilite = $Civilite;
    }

    //Retourne les nom et prénom de la personne en String
    public function toString(): string {
        return $this->getNom()." ".$this->getPrenom();
    }
}
?>

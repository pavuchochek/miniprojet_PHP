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
    
    public function __construct(string $Nom, string $Prenom, Civilite $Civilite, int $Id_personne){
    
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
?>
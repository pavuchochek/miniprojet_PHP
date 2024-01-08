<?php
#Classe de composition (conseil de M. Gaetan Piqué)
class Personne{
    private $_Id_Personne;
    private string $_Nom;
    private string $_Prenom;
    private string $_Civilite;
    
        public function __construct(string $Nom, string $Prenom, string $Civilite)
        {       
            $this->_Nom = $Nom;
            $this->_Prenom = $Prenom;
            $this->_Civilite = $Civilite;
            $this->_Id_Personne = null;
        }
        
        public function getNom(): string
        {
            return $this->_Nom;
        }
        
        public function getPrenom(): string
        {
            return $this->_Prenom;
        }
        
        public function getCivilite(): string
        {
            return $this->_Civilite;
        }
        
        public function getId(): int
        {   if(is_null($this->_Id_Personne)) { return 0;}else{
            
                return $this->_Id_Personne; 
        }
        }

        public function setId(int $id): void
        {
            $this->_Id_Personne = (int)$id;
        }
        
        public function setNom(string $Nom): void
        {
            $this->_Nom = $Nom;
        }
        
        public function setPrenom(string $Prenom): void
        {
            $this->_Prenom = $Prenom;
        }
        
        public function setCivilite(string $Civilite): void
        {
            $this->_Civilite = $Civilite;
        }

        public function toString(): string
        {
            return $this->getNom()." ".$this->getPrenom();
        }
    }
    ?>

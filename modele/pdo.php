<?php
class Connexion extends PDO {
            protected $pdo, $serveur, $utilisateur, $motDePasse, $dataBase;
         
            public function __construct($serveur, $utilisateur, $motDePasse, $dataBase)
            {
                $this->serveur = $serveur;
                $this->utilisateur = $utilisateur;
                $this->motDePasse = $motDePasse;
                $this->dataBase = $dataBase;
         
                $this->connexionBDD();
            }
         
            protected function connexionBDD()
            { 
                try{
                        $this->pdo = new PDO('mysql:host='.$this->serveur.';dbname='.$this->dataBase, $this->utilisateur, $this->motDePasse);
                }
                catch(Exception $e){
                        die(''.$e->getMessage());
                }
            }
}
?>
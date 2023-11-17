<?php
class Connexion extends PDO {
            private $pdo, $serveur, $utilisateur, $motDePasse, $dataBase;
         
            public function __construct($serveur, $utilisateur, $motDePasse, $dataBase)
            {
                $this->serveur = $serveur;
                $this->utilisateur = $utilisateur;
                $this->motDePasse = $motDePasse;
                $this->dataBase = $dataBase;
                try{
                    $this->pdo = new PDO('mysql:host='.$this->serveur.';dbname='.$this->dataBase, $this->utilisateur, $this->motDePasse);
                }
                catch(Exception $e){
                    die(''.$e->getMessage());
                }
            }
            public function getConnexion(){
                return $this->pdo;
            }
}
?>
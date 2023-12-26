<?php
class Connexion extends PDO {
    private static $instance = null;
    private $serveur, $utilisateur, $motDePasse, $dataBase;

    private function __construct($serveur, $utilisateur, $motDePasse, $dataBase)
    {
        $this->serveur = $serveur;
        $this->utilisateur = $utilisateur;
        $this->motDePasse = $motDePasse;
        $this->dataBase = $dataBase;
        try {
            parent::__construct('mysql:host=' . $this->serveur . ';dbname=' . $this->dataBase, $this->utilisateur, $this->motDePasse);
        } catch (Exception $e) {
            die('' . $e->getMessage());
        }
    }

    public static function getInstance($serveur, $utilisateur, $motDePasse, $dataBase)
    {
        if (self::$instance === null) {
            self::$instance = new self($serveur, $utilisateur, $motDePasse, $dataBase);
        }
        return self::$instance;
    }

    public function getConnexion()
    {
        return self::$instance;
    }
}

?>

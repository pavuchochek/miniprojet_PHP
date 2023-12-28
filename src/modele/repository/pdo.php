<?php class Connexion extends PDO {
    private static $instance = null;
    private $serveur, $utilisateur, $motDePasse, $dataBase;

    private function __construct($serveur, $utilisateur, $motDePasse, $dataBase)
    {
        parent::__construct('mysql:host=' . $serveur . ';dbname=' . $dataBase, $utilisateur, $motDePasse);
        $this->serveur = $serveur;
        $this->utilisateur = $utilisateur;
        $this->motDePasse = $motDePasse;
        $this->dataBase = $dataBase;
    }

    public static function getInstance($serveur, $utilisateur, $motDePasse, $dataBase)
    {
        if (self::$instance === null) {
            self::$instance = new self($serveur, $utilisateur, $motDePasse, $dataBase);
        }
        return self::$instance;
    }
}?>

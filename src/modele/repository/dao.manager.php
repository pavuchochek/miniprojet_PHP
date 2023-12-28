<?php class DaoManager {
    private static $instance = null;
    private $connexion;
    private $daoUsager;
    private $daoMedecin;

    private function __construct($db_address, $user, $password, $db_name) {
        $this->connexion = Connexion::getInstance($db_address, $user, $password, $db_name);
        $this->daoUsager = new Dao_Usager($this);
        $this->daoMedecin = new Dao_Medecin($this);
    }

    public static function getInstance($db_address, $user, $password, $db_name) {
        if (self::$instance === null) {
            self::$instance = new self($db_address, $user, $password, $db_name);
        }
        return self::$instance;
    }

    public function getConnexion() {
        return $this->connexion;
    }

    public function getDaoUsager() {
        return $this->daoUsager;
    }

    public function getDaoMedecin() {
        return $this->daoMedecin;
    }
}
?>
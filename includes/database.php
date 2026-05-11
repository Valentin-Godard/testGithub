<?php
namespace App;

use PDO;
use PDOException;

class Database
{
    private static $aa = null;
    private $connection;

    private function __construct()
    {
        $host = "localhost";
        $dbname = "footclub";
        $username = "root";
        $password = "";

        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$aa === null) {
            self::$aa = new Database();
        }
        return self::$aa;
    }
    
    public function getConnection()
    {
        return $this->connection;
    }
}

// On crée l'instance et la variable $connection pour qu'elle soit disponible dans les autres fichiers.
$db = Database::getInstance();
$connection = $db->getConnection();

?>
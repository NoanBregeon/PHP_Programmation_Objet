<?php

public class Bdd{
    $host = "localhost";
    $db='location_vehicules';
    $user ='root';
    $pass ='';
    $port = '3306';
    $charset = 'utf8mb4';

    public function __construct() {
        $options = [
            PDO::ATTR_ERRMODE =>\PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE =>\PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
    }
}




$dsn = "mysql:host=$this->host;dbname=$this->db;port=$this->port;charset=$this->charset";
$this->pdo = new PDO($dsn, $this->user, $this->pass, $this->options);

try{
    $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
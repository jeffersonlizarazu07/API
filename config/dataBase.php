<?php

class DataBase {
    private $host ='localhost';
    private $db_name = 'db_login';
    private $username = 'root';
    private $password = '';
    private $port = '3306';
    public $conn;

    public function getConnection() {
        $this-> conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host, $this->username, $this->password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $this->conn->exec("set names utf8");
            } catch (PDOException $exception) {
                echo "Error de conexión:" . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>

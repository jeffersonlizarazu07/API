<?php
// Definición de la clase Database para gestionar la conexión a la base de datos
class Database
{
    // Propiedades privadas para almacenar los datos de conexión
    private $host = 'localhost';  // Nombre del host de la base de datos
    private $db_name = 'agricol'; // Nombre de la base de datos
    private $username = 'root';   // Nombre de usuario de la base de datos
    private $password = '';       // Contraseña de la base de datos
    private $port = '3307';       // Puerto de la base de datos
    public $conn;                 // Propiedad pública para almacenar la conexión

    // Método para obtener la conexión a la base de datos
    public function getConnection()
    {
        $this->conn = null;

        try {
            // Crear una nueva instancia de PDO para conectar con la base de datos
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            // Establecer el modo de errores para PDO a excepción
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Establece la codificación de caracteres a UTF-8
            $this->conn->exec("set names utf8");

        } catch (PDOException $exception) {
            // Captura y muestra el error si la conexión falla
            die("Error en la conexión: " . $exception->getMessage());
        }

        return $this->conn;
    }
}
?>

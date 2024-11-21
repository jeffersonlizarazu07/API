<?php

require_once "../config/Database.php";

// Definición de la clase UserModel para gestionar operaciones de usuario en la base de datos
class UserModel {
    // Propiedad para la conexión a la base de datos
    private $conn;

    // Propiedades públicas que representan las columnas de la tabla de usuarios
    public $id;
    public $nombre;
    public $pass;
    public $email;

    // Constructor de la clase, establece la conexión a la base de datos al crear una instancia de Database
    public function __construct() {
        $database = new Database(); // Crea una instancia de la clase Database
        $this->conn = $database->getConnection(); // Obtiene y guarda la conexión
    }

// Método para crear un nuevo usuario
public function create()
{
    try {
        // Consulta SQL con parámetros nombrados
        $query = "INSERT INTO usuario (nombre, pass) VALUES (:nombre, :pass)";
        $stmt = $this->conn->prepare($query);

        // Vincular parámetros
        $stmt->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
        $stmt->bindParam(":pass", $this->pass, PDO::PARAM_STR);

        // Ejecutar consulta
        return $stmt->execute();
    } catch (PDOException $e) {
        // Lanza la excepción para depuración
        throw $e;
    }
}


    // Método para leer (consultar) todos los usuarios
    public function read() {
        // Consulta SQL para seleccionar todos los usuarios
        $query = "SELECT * FROM usuario";
        $stmt = $this->conn->prepare($query); // Prepara la consulta SQL
        $stmt->execute(); // Ejecuta la consulta

        return $stmt; // Retorna el resultado de la consulta
    }

    // Método para actualizar la información de un usuario
    public function update($id, $email) {
        try {
            // Consulta SQL para actualizar el email del usuario por ID
            $query = "UPDATE usuario SET email = :email WHERE id = :id";
            $stmt = $this->conn->prepare($query);
    
            // Asigna los valores recibidos
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
            // Ejecuta la consulta
            return $stmt->execute();
        } catch (PDOException $e) {
            // Maneja errores y muestra un mensaje para depuración
            error_log("Error en la actualización: " . $e->getMessage());
            return false;
        }
    }    

    // Método para eliminar un usuario
    public function delete($id) {
        try {
            // Consulta SQL para eliminar un usuario por ID
            $query = "DELETE FROM usuario WHERE id = :id";
            $stmt = $this->conn->prepare($query);
    
            // Asigna el parámetro
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
            // Ejecuta la consulta y devuelve el resultado
            return $stmt->execute();
        } catch (PDOException $e) {
            // Maneja errores
            error_log("Error al eliminar el usuario: " . $e->getMessage());
            return false;
        }
    }
    

    // Método para autenticar un usuario
    public function authenticate() {
        // Consulta SQL para obtener el usuario según su nombre
        $query = "SELECT * FROM usuario WHERE nombre = :nombre";
        $stmt = $this->conn->prepare($query); // Prepara la consulta SQL
        $stmt->bindParam(":nombre", $this->nombre); // Asigna el nombre de usuario
        $stmt->execute(); // Ejecuta la consulta

        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Obtiene el usuario como un arreglo asociativo

        // Verifica si el usuario existe y la contraseña es correcta
        if ($user && password_verify($this->pass, $user['password'])) {
            return ["result" => true]; // Retorna éxito si la autenticación es correcta
        } else {
            return ["result" => false]; // Retorna fallo si la autenticación falla
        }
    }
}
?>

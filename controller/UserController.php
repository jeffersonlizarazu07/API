<?php
// Importa el modelo de usuario (UserModel) para gestionar las operaciones con la base de datos
require_once "C:/xampp/htdocs/API_Web/modelo/UserModel.php";

$id;
// Definición de la clase UserController que contiene los métodos para CRUD y autenticación de usuario
class UserController {
    
    // Método para crear un nuevo usuario
    // Método para registrar un usuario
    public function register($data) {
    // Validar que los datos necesarios estén presentes
    if (!empty($data['usuario']) && !empty($data['pass'])) {
        // Crear una instancia del modelo
        $model = new UserModel();
        
        // Asignar los valores al modelo
        $model->nombre = $data['usuario'];
        $model->pass = $data['pass']; // La contraseña será cifrada en el método create()
        
        // Intentar crear el usuario
        if ($model->create()) {
            http_response_code(201); // Código 201: creado con éxito
            echo json_encode(["message" => "Usuario registrado con éxito"]);
        } else {
            http_response_code(500); // Código 500: error interno del servidor
            echo json_encode(["message" => "Error al registrar el usuario"]);
        }
    } else {
        http_response_code(400); // Código 400: solicitud incorrecta
        echo json_encode(["message" => "Datos incompletos para registrar"]);
    }
}
    


    // Método para leer (consultar) usuarios
    public function read()
    {
        $model = new UserModel(); // Crea una instancia del modelo de usuario
        $stmt = $model->read();   // Llama al método read para obtener los datos
        
        // Verifica si hay datos antes de procesarlos
        if ($stmt) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC); // Convierte los datos en un arreglo asociativo
            echo json_encode($users); // Retorna los datos en formato JSON
        } else {
            echo json_encode(["message" => "Error al leer usuarios"]);
            }
        }
    
    private $model;

    public function update($data) {
        // Crea una instancia del modelo
        $model = new UserModel();
    
        // Verifica y asigna los datos recibidos
        if (!empty($data['id']) && !empty($data['email'])) {
            $id = $data['id'];
            $email = $data['email'];
    
            // Llama al método update del modelo con los datos
            if ($model->update($id, $email)) {
                http_response_code(200); // Código 200: Éxito
                echo json_encode(["message" => "Email actualizado con éxito"]);
            } else {
                http_response_code(500); // Código 500: Error interno del servidor
                echo json_encode(["message" => "Error al actualizar el email"]);
            }
        } else {
            http_response_code(400); // Código 400: Solicitud incorrecta
            echo json_encode(["message" => "Datos incompletos para actualizar"]);
        }
    }
    
    
    // Método para eliminar un usuario
    public function delete($data) {
        if (isset($data['id'])) {
            $model = new UserModel();
            $model->id = $data['id'];
    
            if ($model->delete(34)) {
                http_response_code(200);
                echo json_encode(["message" => "Usuario eliminado con éxito"]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Error al eliminar el usuario"]);
            }
        } else {
            http_response_code(400); // Solicitud incorrecta
            echo json_encode(["message" => "ID no proporcionado"]);
        }
    }
       

    // Método para autenticar a un usuario
        public function authenticate($data = null) {
            // Lógica para autenticar al usuario
            if ($data) {
                $username = $data['usuario'];
                $password = $data['pass'];
                // Verifica en la base de datos (ajusta según tu implementación)
                echo json_encode(["message" => "Autenticación exitosa", "user" => $username, $password]);
            } else {
                echo json_encode(["message" => "Autenticación fallida"]);
            }
        }

    }
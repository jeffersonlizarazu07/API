<?php
header("Content-Type: application/json");

// Importa el modelo y el controlador
require_once __DIR__ . "/../modelo/UserModel.php";
require_once __DIR__ . "/UserController.php";

// Obtiene el método de solicitud HTTP
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Leer los datos del cuerpo de la solicitud
$inputData = json_decode(file_get_contents("php://input"), true);

// Verifica si 'action' está definido en la URL o en el cuerpo JSON
$action = isset($_GET['action']) ? $_GET['action'] : (isset($inputData['action']) ? $inputData['action'] : null);

// Crear instancia del controlador
$controller = new UserController();

if ($requestMethod === 'DELETE') {
    if (isset($inputData['action']) && $inputData['action'] === 'delete') {
        // Pasa los datos al controlador
        $controller->delete($inputData);
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Acción 'delete' no especificada o incorrecta"]);
    }
} elseif ($requestMethod === 'POST') {
    if (isset($inputData['action']) && $inputData['action'] === 'register') {
        $controller->register($inputData);
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Acción 'register' no especificada o incorrecta"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Método no permitido"]);
}
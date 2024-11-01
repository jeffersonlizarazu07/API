<?php
require_once "modelo/UserModel.php";
require_once "UserController.php";


$requestMethod = $_SERVER['REQUEST_METHOD'];


switch ($requestMethod) {
    case 'POST':
        $controller = new UserController();
        if (isset($_GET['action']) && $_GET['action'] == 'authenticate') {
            $controller->authenticate();
        } else {
            $controller->create();
        }
        break;

    case 'GET':
        $controller = new UserController();
        $controller->read();
        break;

    case 'PUT':
        $controller = new UserController();
        $controller->update();
        break;

    case 'DELETE':
        $controller = new UserController();
        $controller->delete();
        break;

    default:
        echo json_encode(["message" => "Método no soportado"]);
        break;
}

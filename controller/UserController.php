<?php
require_once ".../modelo/UserModel.php";

class UserController
{
    public function create()
    {
        $model = new UserModel();

        // Obtener y decodificar datos de entrada
        $data = json_decode(file_get_contents("php://input"));

        // Asignar valores al modelo
        $model->nombre = $data->nombre;
        $model->password = password_hash($data->password, PASSWORD_DEFAULT);

        // Crear usuario y retornar mensaje según el resultado
        if ($model->create()) {
            echo json_encode(["message" => "Usuario creado exitosamente"]);
        } else {
            echo json_encode(["message" => "Error al crear el usuario"]);
        }
    }

    public function read()
    {
        $model = new UserModel();
        $stmt = $model->read();
        
        // Verificar si hay datos antes de decodificar
        if ($stmt) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($users);
        } else {
            echo json_encode(["message" => "Error al leer usuarios"]);
        }
    }

    public function update()
    {
        $model = new UserModel();

        $data = json_decode(file_get_contents("php://input"));

        // Asignar valores de actualización al modelo
        $model->id = $data->id;
        $model->nombre = $data->nombre;
        $model->password = password_hash($data->password, PASSWORD_DEFAULT);

        if ($model->update()) {
            echo json_encode(["message" => "Usuario actualizado exitosamente"]);
        } else {
            echo json_encode(["message" => "Error al actualizar usuario"]);
        }
    }

    public function delete()
    {
        $model = new UserModel();

        $data = json_decode(file_get_contents("php://input"));
        $model->id = $data->id;

        if ($model->delete()) {
            echo json_encode(["message" => "Usuario eliminado exitosamente"]);
        } else {
            echo json_encode(["message" => "Error al eliminar el usuario"]);
        }
    }

    public function authenticate()
    {
        $model = new UserModel();

        $data = json_decode(file_get_contents("php://input"));

        // Asignar valores de autenticación al modelo
        $model->nombre = $data->nombre;
        $model->password = $data->password;
        
        // Llamar al método authenticate y verificar resultados
        $authResult = $model->authenticate();

        header("Content-Type: application/json");
        if ($authResult["result"]) {
            echo json_encode(["message" => "Autenticación exitosa."]);
        } else {
            echo json_encode([
                "message" => "Error en la autenticación.",
                "query" => $authResult["query"] ?? '',
                "rows" => $authResult["rows"] ?? 0
            ]);
        }
    }
}
?>

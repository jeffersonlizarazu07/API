<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['nombre'];
    $password = $_POST['password'];

    // Validación básica (reemplaza esto con una validación segura de tu base de datos)
    if ($username === 'Jefferson' && $password === '123456') {
        echo "Inicio de sesión exitoso";
    } else {
        echo "Error: usuario o contraseña incorrectos";
    }
} else {
    echo "Método no permitido";
}

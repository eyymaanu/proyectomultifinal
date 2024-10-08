<?php
session_start(); // Iniciar la sesión

include('../config/database.php'); // Incluir la configuración de la base de datos
include('../config/encriptar.php'); // Incluir funciones de encriptación
include('../models/Auth.php'); // Incluir el modelo Auth

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario']; // Obtener el nombre de usuario del formulario
    $contrasena = $_POST['contrasena']; // Obtener la contraseña del formulario
    $conn = Database::getConnection(); // Obtener la conexión a la base de datos
    $auth = new Auth($conn); // Crear una instancia de la clase Auth 

    if ($auth->login($usuario, $contrasena)) {
        // El inicio de sesión fue exitoso, iniciar la sesión
        $_SESSION['usu_codigo'] = $auth->getUserId(); // Suponiendo que hay un método para obtener el ID del usuario
        $_SESSION['usu_role'] = $auth->getUserRole(); // Suponiendo que hay un método para obtener el rol del usuario

        if($_SESSION['usu_role'] === 1) {
            // Si el usuario es administrador, redirigir al panel de administrador
            header("Location: ../index.php?page=admin/dashboard");
            exit();
        }else{
            // Si el usuario es consumidor, redirigir al catálogo
        header("Location: ../index.php?page=consumidor/catalogo");
        exit();
        }
    } else {
        // Manejar error de inicio de sesión
        $error = "Nombre de usuario o contraseña incorrectos.";
        header("Location: ../views/auth/login.php?error=" . urlencode($error));
        exit();
    }
}


?>

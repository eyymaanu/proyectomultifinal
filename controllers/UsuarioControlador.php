<?php
include('../config/database.php'); // Incluir la configuración de la base de datos
include('../config/encriptar.php'); // Incluir funciones de encriptación
require_once '../models/RegistrarUsuarioModelo.php'; // Incluir el modelo de registro de usuarios


// Manejo de la solicitud de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $telefono = $_POST['telefono'];
    $modalidad = $_POST['modalidad'];
    $curso = $_POST['curso'];
    $cedula = $_POST['cedula'];
    $role = $_POST['role']; // Obtener el rol del formulario
    $contrasena = $_POST['contrasena']; // Obtener la contraseña del formulario

    try {
        $conn = Database::getConnection(); // Obtener la conexión a la base de datos
        $userController = new RegistrarUsuarioModelo($conn); // Crear instancia de UsuarioControlador

        // Crear instancia de UsuarioModelo
        if ($userController->verificarDuplicados($usuario, $telefono, $correo, $cedula)) {
            echo json_encode(['success' => false, 'message' => 'El nombre de usuario, teléfono, correo o cédula ya están registrados']);
            exit();
        } else if ($userController->register($nombre, $apellido, $correo, $telefono, $modalidad, $curso, $cedula, $role, $contrasena, $usuario)) {
            echo json_encode(['success' => true, 'message' => 'Usuario registrado exitosamente']);
        } else {
            // Manejo de errores, puedes guardar el mensaje en sesión o similar
            echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario']);
        }
    } catch (Exception $e) {
        // Enviar una respuesta JSON con el mensaje de error
        echo json_encode(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
    }
    exit(); // Asegurarse de que no se siga ejecutando el script
}
?>
<?php
session_start();
include('../models/Auth.php');
include('../config/database.php');

$conn = Database::getConnection(); // Obtener la conexión a la base de datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     // Establecer el tipo de contenido como JSON

    if (isset($_POST['token']) && !empty($_POST['token'])) {
        $token = $_POST['token'];
        

        // Validar el token
        $sql = 'SELECT usu_codigo FROM usuarios WHERE token = :token';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Si el token es válido, procesar el cambio de contraseña
            if (isset($_POST['nueva_contra']) && isset($_POST['confirmar_contra'])) {
                $nueva_contra = $_POST['nueva_contra'];
                $confirmar_contra = $_POST['confirmar_contra'];

                // Validar que las contraseñas coincidan
                if ($nueva_contra === $confirmar_contra) {
                    // Hashear la nueva contraseña
                    $hashed_password = password_hash($nueva_contra, PASSWORD_DEFAULT);

                    // Preparar la consulta para actualizar la contraseña y expirar el token
                    $sql = 'UPDATE usuarios SET usu_contrasena = :nueva_contra, token = NULL WHERE token = :token';
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':nueva_contra', $hashed_password);
                    $stmt->bindParam(':token', $token);

                    // Ejecutar la consulta
                    if ($stmt->execute()) {
                        // Enviar una respuesta de éxito en formato JSON
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Contraseña actualizada exitosamente.'
                        ]);
                        exit();
                    } else {
                        // Enviar una respuesta de error en formato JSON
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Error al actualizar la contraseña. Inténtalo de nuevo.'
                        ]);
                        exit();
                    }
                } else {
                    // Enviar una respuesta de error en formato JSON si las contraseñas no coinciden
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Las contraseñas no coinciden.'
                    ]);
                    exit();
                }
            }

        } else {
            // Enviar una respuesta de error en formato JSON si el token es inválido
            echo json_encode([
                'status' => 'error',
                'message' => 'Token inválido o ya utilizado.'
            ]);
            exit();
        }
    } else {
        // Enviar una respuesta de error en formato JSON si no se recibe el token
        echo json_encode([
            'status' => 'error',
            'message' => 'Token no recibido.'
        ]);
        exit();
    }
}
?>

<?php
require_once '../config/database.php'; // Incluir el archivo Database.php para poder instanciar la conexión
require_once '../models/autorModelo.php'; // Incluir el archivo autorModelo.php para poder instanciar el modelo de autores


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['autor_nombre'];

    try {
        // Crear conexión y guardar el autor en la base de datos
        $conn = Database::getConnection();
        $autorModelo = new autorModelo($conn);

        // Intentar agregar el autor
        if($autorModelo->agregarAutor($nombre)) {
            echo json_encode(['success' => true, 'message' => 'Autor agregado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al agregar el autor']);
        }
    } catch (Exception $e) {
        // Enviar una respuesta JSON con el mensaje de error
        echo json_encode(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
    }

    exit(); // Asegurarse de que no se siga ejecutando el script
}
?>

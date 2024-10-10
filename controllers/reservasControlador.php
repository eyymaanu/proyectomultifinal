<?php
include('../models/libroModelo.php'); // Incluir la configuración de la base de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuarioId = $_POST['usuario_id'];        // ID del usuario que realiza la reserva
    $libroId = $_POST['libro_id'];            // ID del libro que se desea reservar
    $cantidad = (int)$_POST['cantidad'];      // Cantidad seleccionada por el usuario

    $conn = Database::getConnection();
    $libroModelo = new LibroModelo($conn);
    // Verificar si hay suficiente stock para la cantidad solicitada
    if ($libroModelo->verificarStockParaReserva($libroId, $cantidad)) {
        try {
            // Registrar la reserva con la cantidad seleccionada
            $libroModelo->registrarReserva($usuarioId, $libroId, $cantidad);
            
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error al registrar la reserva']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
    }
}


?>
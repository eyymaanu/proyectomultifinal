<?php
require_once($_SERVER['DOCUMENT_ROOT']).'/proyectofinalmulti/models/libroModelo.php)'
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuarioId = $_SESSION['user_id'];        // ID del usuario que realiza la reserva
    $libroId = $_POST['libro_id'];            // ID del libro que se desea reservar
    $cantidad = (int)$_POST['cantidad'];      // Cantidad seleccionada por el usuario

    // Verificar si hay suficiente stock para la cantidad solicitada
    if (verificarStockParaReserva($libroId, $cantidad)) {
        try {
            // Registrar la reserva con la cantidad seleccionada
            registrarReserva($usuarioId, $libroId, $cantidad);
            echo "Reserva realizada exitosamente.";
        } catch (Exception $e) {
            echo "Error al realizar la reserva: " . $e->getMessage();
        }
    } else {
        echo "No hay suficiente stock disponible para la cantidad solicitada.";
    }
}


?>
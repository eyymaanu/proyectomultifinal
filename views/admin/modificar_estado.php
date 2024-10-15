<?php
require_once '../../config/database.php';
$pdo = Database::getConnection();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reserva_id = $_POST['reserva_id'];
    $nuevo_estado = $_POST['estado'];

    $stmt = $pdo->prepare("UPDATE reservas SET estado = ? WHERE res_id = ?");
    $stmt->execute([$nuevo_estado, $reserva_id]);

   
}

// Conexión a la base de datos
$pdo = Database::getConnection();

// Verificar si el estado de la reserva se cambia a 'completada'
if ($_POST['estado'] === 'completada') {
    $reserva_id = $_POST['reserva_id'];

    // Obtener la información de la reserva
    $stmt = $pdo->prepare("SELECT * FROM reservas WHERE res_id = :res_id");
    $stmt->execute([':res_id' => $reserva_id]);
    $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reserva) {
        // Calcular la fecha de devolución (2 semanas después de la fecha actual)
        $fecha_devolucion = $_POST['fecha_devolucion'];

        // Insertar un nuevo registro en prestamo_cab
        $stmt_insert_cab = $pdo->prepare("
            INSERT INTO prestamo_cab (pre_fecha, pre_fechadev, presc_usu_codigo) 
            VALUES (NOW(), :fecha_devolucion, :usuario_id)
        ");
        $stmt_insert_cab->execute([
            ':fecha_devolucion' => $fecha_devolucion,
            ':usuario_id' => $reserva['res_usuario_id']
        ]);
        $prestamo_id = $pdo->lastInsertId();

        // Insertar los detalles en prestamos_detalles
        $stmt_insert_det = $pdo->prepare("
            INSERT INTO prestamos_detalles (prest_codigonum, presd_cantidad, presd_libros_codigo)
            VALUES (:prestamo_id, :cantidad, :libro_id)
        ");
        $stmt_insert_det->execute([
            ':prestamo_id' => $prestamo_id,
            ':cantidad' => $reserva['res_cantidad'],
            ':libro_id' => $reserva['res_libro_id']
        ]);

        // Eliminar la reserva de la tabla de reservas
        $stmt_delete_reserva = $pdo->prepare("DELETE FROM reservas WHERE res_id = :res_id");
        $stmt_delete_reserva->execute([':res_id' => $reserva_id]);
        header('Location: ../../index.php?page=admin/ReservarLibro');
        
    } else {
        echo "No se encontró la reserva.";
    }
}


?>

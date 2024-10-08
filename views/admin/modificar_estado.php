<?php
require_once '../../config/database.php';
$pdo = Database::getConnection();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reserva_id = $_POST['reserva_id'];
    $nuevo_estado = $_POST['estado'];

    $stmt = $pdo->prepare("UPDATE reservas SET estado = ? WHERE res_id = ?");
    $stmt->execute([$nuevo_estado, $reserva_id]);

   
}
if ($_POST['estado'] === 'completada') {
    $reserva_id = $_POST['res_id'];

    // Obtener la información de la reserva
    $stmt = $pdo->prepare("SELECT * FROM reservas WHERE res_id = :res_id");
    $stmt->execute([':res_id' => $reserva_id]);
    $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reserva) {
        // Insertar un nuevo registro en prestamo_cab
        $stmt_insert_cab = $pdo->prepare("
            INSERT INTO prestamo_cab (pre_fecha, presc_usu_codigo) 
            VALUES (NOW(), :usuario_id)
        ");
        $stmt_insert_cab->execute([':usuario_id' => $reserva['res_usuario_id']]);
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

        // Cambiar el estado de la reserva a completada
        $stmt_update_reserva = $pdo->prepare("
            UPDATE reservas 
            SET estado = 'completada' 
            WHERE res_id = :res_id
        ");
        $stmt_update_reserva->execute([':res_id' => $reserva_id]);

        echo "Reserva convertida en préstamo exitosamente.";
        header('Location: ../../index.php?page=admin/ReservarLibro');
        exit;
    } else {
        echo "No se encontró la reserva.";
    }
}
?>

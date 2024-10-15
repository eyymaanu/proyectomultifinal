<?php
// Conexión a la base de datos
require_once '../config/database.php'; 
require_once '../models/libroModelo.php';
$pdo = Database::getConnection();

try {
    $libroModel = new libroModelo($pdo);

    // Verificar si se está realizando una devolución
    if (isset($_POST['prestamo_id'])) {
        $prestamo_id = $_POST['prestamo_id'];

        // Obtener los detalles del préstamo junto con el título del libro
        $stmt = $pdo->prepare("
            SELECT pd.presd_libros_codigo, pd.presd_cantidad, l.lib_titulo 
            FROM prestamos_detalles pd
            JOIN libros l ON pd.presd_libros_codigo = l.lib_codigo
            WHERE pd.prest_codigonum = :prestamo_id
        ");
        $stmt->execute([':prestamo_id' => $prestamo_id]);
        $detalles = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($detalles) {
            $libro_id = $detalles['presd_libros_codigo'];
            $cantidad_devuelta = $detalles['presd_cantidad'];
            $libro_titulo = $detalles['lib_titulo']; // Ahora tienes el título del libro

            // Actualizar el del libro
            $actualizarStock = $libroModel->actualizarStock($libro_id, $cantidad_devuelta);

            // Registrar la devolución en `devolucion_cab` y `devolucion_detalles`
            if ($actualizarStock) {
                // Insertar en devolucion_cab
                $fecha_devolucion = date('Y-m-d H:i:s');
                $stmt_insert_cab = $pdo->prepare("
                    INSERT INTO devolucion_cab (devo_fecha, devo_fechadev, devo_usu_codigo) 
                    SELECT pre_fecha, :fecha_devolucion, presc_usu_codigo 
                    FROM prestamo_cab WHERE pre_codigo = :prestamo_id
                ");
                $stmt_insert_cab->execute([
                    ':fecha_devolucion' => $fecha_devolucion,
                    ':prestamo_id' => $prestamo_id
                ]);

                // Obtener el ID de la cabecera insertada
                $devolucion_numero = $pdo->lastInsertId();

                // Insertar en devolucion_detalles
                $stmt_insert_detalle = $pdo->prepare("
                    INSERT INTO devolucion_detalles (devo_codigonum, devo_arti, devo_cantidad, devo_libros_codigo) 
                    VALUES (:devolucion_numero, :libro_titulo, :cantidad, :libro_id)
                ");
                $stmt_insert_detalle->execute([
                    ':devolucion_numero' => $devolucion_numero,
                    ':libro_titulo' => $libro_titulo,
                    ':cantidad' => $cantidad_devuelta,
                    ':libro_id' => $libro_id
                ]);

                // Eliminar primero los detalles del préstamo
                $stmt_delete_detalles = $pdo->prepare("DELETE FROM prestamos_detalles WHERE prest_codigonum = :prestamo_id");
                $stmt_delete_detalles->execute([':prestamo_id' => $prestamo_id]);

                // Luego eliminar el préstamo de la cabecera
                $stmt_delete_prestamo = $pdo->prepare("DELETE FROM prestamo_cab WHERE pre_codigo = :prestamo_id");
                $stmt_delete_prestamo->execute([':prestamo_id' => $prestamo_id]);

                header('Location: ../index.php?page=admin/PrestarLibro'); 
                exit(); 
            } else {
                
                header('Location: ../index.php?page=admin/PrestarLibro&error=devolucion_fallida');
                exit();
            }
        } else {
            
            header('Location: ../index.php?page=admin/PrestarLibro&error=prestamo_no_encontrado');
            exit();
        }
    } else {
    
        header('Location: ../index.php?page=admin/PrestarLibro&error=datos_incompletos');
        exit();
    }
} catch (Exception $e) {

    error_log('Error en devolucion.php: ' . $e->getMessage());
    header('Location: ../index.php?page=admin/PrestarLibro&error=error_interno');
    exit();
}

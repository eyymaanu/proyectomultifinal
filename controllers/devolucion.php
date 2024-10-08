<?php
// Conexión a la base de datos
require_once '../config/database.php' ;// Incluir el archivo Database.php para poder instanciar la conexión
$pdo = Database::getConnection();
// Verificar si se está realizando una devolución
if (isset($_POST['devolver'])) {
    $prestamo_id = $_POST['prestamo_id']; // ID del préstamo a devolver
    // Obtener los detalles del préstamo
    $stmt = $pdo->prepare("SELECT presd_cantidad, presd_libros_codigo FROM prestamos_detalles WHERE prest_codigonum = :prestamo_id");
    $stmt->execute([':prestamo_id' => $prestamo_id]);
    $detalles = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($detalles) {
        // Aumentar el stock del libro en la tabla libros
        $libro_id = $detalles['presd_libros_codigo'];
        $cantidad_devuelta = $detalles['presd_cantidad'];

        // Actualizar stock en la tabla libros
        $stmt_update_stock = $pdo->prepare("UPDATE libros SET stock_actual = stock_actual + :cantidad WHERE lib_codigo = :libro_id");
        $stmt_update_stock->execute([
            ':cantidad' => $cantidad_devuelta,
            ':libro_id' => $libro_id
        ]);

        // Registrar la fecha de devolución en prestamo_cab
        $fecha_devolucion = date('Y-m-d H:i:s');
        $stmt_update_prestamo = $pdo->prepare("UPDATE prestamo_cab SET pre_fechadev = :fecha_devolucion WHERE pre_codigo = :prestamo_id");
        $stmt_update_prestamo->execute([
            ':fecha_devolucion' => $fecha_devolucion,
            ':prestamo_id' => $prestamo_id
        ]);

        echo "El préstamo ha sido devuelto exitosamente.";
    } else {
        echo "No se encontraron detalles del préstamo.";
    }
}
?>

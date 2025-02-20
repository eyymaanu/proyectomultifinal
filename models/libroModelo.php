<?php

require_once '../config/database.php'; // Incluir el archivo Database.php para poder instanciar la conexión; 
class LibroModelo {
    private $db;
    
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    function agregarLibro($titulo, $autor, $categoria, $imagenBinaria, $cantidad, $stock) {
        // Preparar la consulta
        $stmt = $this->db->prepare("INSERT INTO libros (lib_autor_codigo, lib_titulo, lib_categoria, lib_img, lib_cantidad_real, stock_actual) VALUES (:autor, :titulo, :categoria, :img, :cantidadreal, :stockreal)");
        $stmt->bindParam(':autor', $autor);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':categoria', $categoria); 
        $stmt->bindParam(':img', $imagenBinaria, PDO::PARAM_LOB);  // Guardar la imagen como binario (BLOB)
        $stmt->bindParam(':cantidadreal', $cantidad);
        $stmt->bindParam(':stockreal', $stock);
        
        return $stmt->execute(); // Retorna el resultado de la ejecución


    } 

    function actualizarLibro($autor, $titulo, $categoria, $imgData, $cantidad, $stock, $codigo) {
        $stmt = $this->db->prepare("UPDATE libros SET lib_autor_codigo = :autor, lib_titulo = :titulo, lib_categoria = :categoria, lib_img = :img, lib_cantidad_real = :cantidadreal, stock_actual = :stockreal WHERE lib_codigo = :codigo");
        $stmt->bindParam(':autor', $autor);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':categoria', $categoria); 
        $stmt->bindParam(':img', $imgData, PDO::PARAM_LOB);  // Guardar la imagen como binario (BLOB)
        $stmt->bindParam(':cantidadreal', $cantidad);
        $stmt->bindParam(':stockreal', $stock);
        $stmt->bindParam(':codigo', $codigo);
        return $stmt->execute();
    }
   function eliminarlibro($lib_codigo) {
    try {
        // Primero, eliminar los registros dependientes en la tabla devolucion_detalles
        $stmt_delete_detalles = $this->db->prepare("DELETE FROM devolucion_detalles WHERE devo_libros_codigo = :libro_id");
        $stmt_delete_detalles->execute([':libro_id' => $lib_codigo]);

        // Ahora puedes eliminar el libro
        $stmt = $this->db->prepare("DELETE FROM libros WHERE lib_codigo = :codigo");
        $stmt->bindParam(':codigo', $lib_codigo);

        // Ejecutar la eliminación del libro
        return $stmt->execute();
    } catch (Exception $e) {
        // Manejo de errores
        return false; // Puedes optar por manejar el error de otra forma según lo que necesites
    }
}

    

    function verificarDuplicados($titulo){
        $sql = "SELECT lib_titulo FROM libros WHERE lib_titulo = :titulo";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result !== false;
    }

    function verificarDisponibilidad($libroId){
        $sql = "SELECT stock_actual FROM libros WHERE lib_codigo = :codigo";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':codigo', $libroId);
        $stmt->execute();
        $libro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $libro && $libro['stock_actual'] > 0;
    } 



    function registrarPrestamo($usuarioId,$libroId,$cantidad,$fechaDevolucion){
        $pdo = Database::getConnection();
        try{
            //se inicia una transaccion que hace que todas las consultas se ejecuten en un solo bloque
            $pdo->beginTransaction();
            //se inserta el registro de la cabecera del prestamo
            $queryCab = "INSERT INTO prestamo_cab (pre_fecha, pre_fechadev, presc_usu_codigo) VALUES (NOW(), :fechaDevolucion, :usuarioId)";
            $stmtCab = $pdo->prepare($queryCab);
            $stmtCab->bindParam(':fechaDevolucion', $fechaDevolucion);
            $stmtCab->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
            $stmtCab->execute();

            //se obtiene el id del prestamo recien insertado
            $prestamoCabId = $pdo->lastInsertId();

            //se inserta el detalle del prestamo
            $queryDet = "INSERT INTO prestamos_detalles (prest_codigonum, presd_libros_codigo, presd_cantidad ) VALUES (:prestamoCabId, :libroId, :cantidad)";
            $stmtDet = $pdo->prepare($queryDet);
            $stmtDet->bindParam(':prestamoCabId', $prestamoCabId, PDO::PARAM_INT);
            $stmtDet->bindParam(':libroId', $libroId, PDO::PARAM_INT);
            $stmtDet->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmtDet->execute();

              // Actualizar el stock del libro
            $queryUpdateStock = "UPDATE libros SET stock_actual = stock_actual - :cantidad WHERE lib_codigo = :libroId";
            $stmtStock = $pdo->prepare($queryUpdateStock);
            $stmtStock->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmtStock->bindParam(':libroId', $libroId, PDO::PARAM_INT);
            $stmtStock->execute();
            
            //se inserta el registro en el historial de stock
          
            //se confirma la transaccion
            $pdo->commit();
            return true;
        }catch(Exception $e){
            //si ocurre un error se revierte la transaccion
            $pdo->rollBack();
            return false;
        }

    }
    function verificarStockParaReserva($libroId, $cantidad) {
        $pdo = Database::getConnection();
        
        // Consultar el stock actual del libro
        $query = "SELECT stock_actual FROM libros WHERE lib_codigo = :libroId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':libroId', $libroId, PDO::PARAM_INT);
        $stmt->execute();
        $libro = $stmt->fetch();
    
        // Verificar si el stock es suficiente
        return $libro && $libro['stock_actual'] >= $cantidad;
    }
    
    function registrarReserva($usuarioId, $libroId, $cantidad) {
        $pdo = Database::getConnection();
        
        try {
            // Iniciar la transacción
            $pdo->beginTransaction();
    
            // Insertar la reserva en la tabla `reservas`
            $queryReserva = "INSERT INTO reservas (res_fecha, res_usuario_id, res_libro_id, res_cantidad, estado) 
                             VALUES (NOW(), :usuarioId, :libroId, :cantidad, 'pendiente')";
            $stmtReserva = $pdo->prepare($queryReserva);
            $stmtReserva->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
            $stmtReserva->bindParam(':libroId', $libroId, PDO::PARAM_INT);
            $stmtReserva->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmtReserva->execute();
            
            // Restar del stock actual
            $queryUpdateStock = "UPDATE libros SET stock_actual = stock_actual - :cantidad WHERE lib_codigo = :libroId";
            $stmtStock = $pdo->prepare($queryUpdateStock);
            $stmtStock->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmtStock->bindParam(':libroId', $libroId, PDO::PARAM_INT);
            $stmtStock->execute();
    
            // Registrar en el historial de stock
         
            // Confirmar la transacción
            $pdo->commit();
            
            return true;
        } catch (Exception $e) {
            // Si hay error, revertir la transacción
            $pdo->rollBack();
            throw $e;
        }
    }
    
    public function obtenerDetallesPrestamo($prestamo_id)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT presd_cantidad, presd_libros_codigo FROM prestamos_detalles WHERE prest_codigonum = :prestamo_id");
        $stmt->execute([':prestamo_id' => $prestamo_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar el stock del libro
    public function actualizarStock($libro_id, $cantidad_devuelta)
    {
        $pdo = Database::getConnection();
        $stmt_update_stock = $pdo->prepare("UPDATE libros SET stock_actual = stock_actual + :cantidad WHERE lib_codigo = :libro_id");
        return $stmt_update_stock->execute([
            ':cantidad' => $cantidad_devuelta,
            ':libro_id' => $libro_id
        ]);
    }

    // Registrar la fecha de devolución
    public function registrarDevolucion($prestamo_id)
{
    try {
        $pdo = Database::getConnection();
        $pdo->beginTransaction(); // Iniciar transacción para asegurar atomicidad
        
        // Obtener los datos del préstamo desde `prestamo_cab`
        $stmt_prestamo = $pdo->prepare("SELECT pre_fecha, presc_usu_codigo FROM prestamo_cab WHERE pre_codigo = :prestamo_id");
        $stmt_prestamo->execute([':prestamo_id' => $prestamo_id]);
        $prestamo = $stmt_prestamo->fetch(PDO::FETCH_ASSOC);

        if ($prestamo) {
            $fecha_prestamo = $prestamo['pre_fecha'];
            $usuario_id = $prestamo['presc_usu_codigo'];
            $fecha_devolucion = date('Y-m-d H:i:s');
            
            // Insertar en `devolucion_cab`
            $stmt_insert_cab = $pdo->prepare("
                INSERT INTO devolucion_cab (devo_fecha, devo_fechadev, devo_usu_codigo) 
                VALUES (:fecha_prestamo, :fecha_devolucion, :usuario_id)
            ");
            $stmt_insert_cab->execute([
                ':fecha_prestamo' => $fecha_prestamo,
                ':fecha_devolucion' => $fecha_devolucion,
                ':usuario_id' => $usuario_id
            ]);

            // Obtener el ID de la cabecera de devolución recién insertada
            $devolucion_numero = $pdo->lastInsertId();

            // Obtener los detalles del préstamo (libros prestados)
            $stmt_detalles = $pdo->prepare("SELECT presd_libros_codigo, presd_cantidad FROM prestamos_detalles WHERE prest_codigonum = :prestamo_id");
            $stmt_detalles->execute([':prestamo_id' => $prestamo_id]);
            $detalles = $stmt_detalles->fetchAll(PDO::FETCH_ASSOC);

            if ($detalles) {
                // Insertar cada detalle de la devolución en `devolucion_detalles`
                foreach ($detalles as $detalle) {
                    $libro_id = $detalle['presd_libros_codigo'];
                    $cantidad = $detalle['presd_cantidad'];

                    $stmt_insert_detalle = $pdo->prepare("
                        INSERT INTO devolucion_detalles (devo_codigonum, devo_cantidad, devo_libros_codigo) 
                        VALUES (:devolucion_numero, :cantidad, :libro_id)
                    ");
                    $stmt_insert_detalle->execute([
                        ':devolucion_numero' => $devolucion_numero,
                        ':cantidad' => $cantidad,
                        ':libro_id' => $libro_id
                    ]);
                }
            }

            // Eliminar los detalles del préstamo de la tabla `prestamos_detalles` primero
            $stmt_delete_detalles = $pdo->prepare("DELETE FROM prestamos_detalles WHERE prest_codigonum = :prestamo_id");
            $stmt_delete_detalles->execute([':prestamo_id' => $prestamo_id]);

            // Luego eliminar el préstamo de la tabla `prestamo_cab`
            $stmt_delete_prestamo = $pdo->prepare("DELETE FROM prestamo_cab WHERE pre_codigo = :prestamo_id");
            $stmt_delete_prestamo->execute([':prestamo_id' => $prestamo_id]);

            // Confirmar la transacción
            $pdo->commit();

            return true; // Devolución registrada exitosamente
        } else {
            // Si no se encuentra el préstamo, se revierte la transacción
            $pdo->rollBack();
            return false; // Error al registrar la devolución
        }
    } catch (Exception $e) {
        // En caso de error, revertir transacción y manejar excepción
        $pdo->rollBack();
        throw new Exception('Error al registrar la devolución: ' . $e->getMessage());
    }
}

    



}
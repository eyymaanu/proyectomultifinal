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
    function eliminarlibro($lib_codigo){
        $stmt = $this->db->prepare("DELETE FROM libros WHERE lib_codigo = :codigo");
        $stmt->bindParam(':codigo', $lib_codigo);
        return $stmt->execute();
    }

    function verificarDuplicados($titulo){
        $sql = "SELECT lib_titulo FROM libros WHERE lib_titulo = :titulo";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result !== false;
    }
    function verificarDisponibilidad($codigo){
        $sql = "SELECT stock_actual FROM libros WHERE lib_codigo = :codigo";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        $libro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $libro && $libro['stock_actual'] > 0;
    } 



    function registrarPrestamo($usuarioId,$libroId,$cantidad,$fechaDevolucion = null){
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
            $queryDet = "INSERT INTO prestamos_detalles (presd_codigo, presd_lib_codigo, presd_cantidad ) VALUES (:prestamoCabId, :libroId, :cantidad)";
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
            $queryStockHist = "INSERT INTO stock (stck_art_codigo, stock_cant, fecha_movimiento, tipo_movimiento)
                           VALUES (:libroId, :cantidad, NOW(), 'salida')";
            $stmtStockHist = $pdo->prepare($queryStockHist);
            $stmtStockHist->bindParam(':libroId', $libroId, PDO::PARAM_INT);
            $stmtStockHist->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmtStockHist->execute();

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
            $queryStockHist = "INSERT INTO stock (stck_art_codigo, stock_cant, fecha_movimiento, tipo_movimiento)
                               VALUES (:libroId, :cantidad, NOW(), 'salida')";
            $stmtStockHist = $pdo->prepare($queryStockHist);
            $stmtStockHist->bindParam(':libroId', $libroId, PDO::PARAM_INT);
            $stmtStockHist->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmtStockHist->execute();
    
            // Confirmar la transacción
            $pdo->commit();
            
            return true;
        } catch (Exception $e) {
            // Si hay error, revertir la transacción
            $pdo->rollBack();
            throw $e;
        }
    }


    



}
?>
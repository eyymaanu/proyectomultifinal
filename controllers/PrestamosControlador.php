<?php
include('../config/database.php'); // Incluir la configuración de la base de datos
include('../models/libroModelo.php'); // Incluir la configuración de la base de datos

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $usuarioId = $_POST['usu_codigo'] ;
    $libroId = $_POST['lib_codigo'];
    $cantidad = (int)$_POST['cantidad'];
    $fechaDevolucion= $_POST['fecha_devolucion'];

    $conn = Database::getConnection();
    $modelo = new LibroModelo($conn);
    

    //verificamos la disponibilidad del libro
    if($modelo->verificarDisponibilidad($libroId)){
        try{
            if($modelo->registrarPrestamo($usuarioId,$libroId,$cantidad,$fechaDevolucion)){
                echo json_encode(['success' => true, 'message' => 'El prestamo se realizó correctamente']);
                exit();
            }else{
                echo json_encode(['error' => true, 'message' => 'Ndoikoi koanga']);
                exit();
            }
        }catch (Exception $e ){
            echo json_encode(['error' => false, 'message' => 'El prestamo no pudo realizarse']);
            exit();
        }
    }else{
        echo "No hay disponibilidad de este libro";
    }
    
}






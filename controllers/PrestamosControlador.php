<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/ProyectoFinalMulti/config/database.php'); // Incluir el archivo Database.php
require_once($_SERVER['DOCUMENT_ROOT']).'/proyectofinalmulti/models/libroModelo.php)'

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $usuarioId = $_SESSION['usu_codigo'] ;
    $libroId = $_POST['lib_codigo'];
    $cantidad = 1;
    $fechaDevolucion= $_POST['fecha_devolucion'];


    //verificamos la disponibilidad del libro
    if(verificarDisponibilidad($libroId)){
        try{
            registrarPrestamo($usuarioId,$libroId,$cantidad,$fechaDevolucion);
            echo "Prestamos Registrado Exitosamente";
        }catch (Exception $e ){
            echo "Error al registrar el prestamo". $e->getMessage();
        }
    }else{
        echo "No hay disponibilidad de este li3bro";
    }
    
}





?>


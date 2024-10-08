<?php
 require_once '../config/database.php' ;// Incluir el archivo Database.php para poder instanciar la conexión
 require_once '../models/autorModelo.php' ;// Incluir el archivo autorModelo.php para poder instanciar el modelo de autores

if($_SERVER['REQUEST_METHOD']=== 'POST'){
    $nombre = $_POST['autor_nombre'];
    $id = $_POST['Autores_id'];

    if(empty($nombre) || empty($id)){
        header("Location: ../index.php?page=admin/editarAutor&error=" . urlencode("Todos los campos son obligatorios"));
        exit();
    }

    try{
        $conn = Database::getConnection();
        $autorModelo = new autorModelo($conn);
        if($autorModelo->actualizarAutor($id, $nombre)){
            header("Location: ../index.php?page=admin/gestionarAutor");
            exit();
        }else{
            header("Location: ../index.php?page=admin/gestionarAutor&error=" . urlencode("Error al actualizar el autor"));
            exit();
        }
    }catch(Exception $e){
        echo json_encode(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
    }
    exit();
}
?>
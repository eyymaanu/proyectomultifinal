<?php
 require_once '../config/database.php' ;// Incluir el archivo Database.php para poder instanciar la conexión
 require_once '../models/autorModelo.php' ;// Incluir el archivo autorModelo.php para poder instanciar el modelo de autores

if($_SERVER['REQUEST_METHOD']=== 'POST'){
    $id = $_POST['Autores_id'];
    try{
        $conn = Database::getConnection();
        $autorModelo = new autorModelo($conn);
        if($autorModelo->eliminarAutor($id)){
            header("Location: ../index.php?page=admin/gestionarAutor");
        }else{
            header("Location: ../index.php?page=admin/gestionarAutor&error=" . urlencode("Error al eliminar el autor"));
        }
    }catch(Exception $e){
        echo json_encode(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
    }
    exit();
}
?>
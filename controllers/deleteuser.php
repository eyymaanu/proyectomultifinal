<?php
 require_once '../config/database.php' ;// Incluir el archivo Database.php para poder instanciar la conexión
 require_once '../models/RegistrarUsuarioModelo.php';// Incluir el archivo autorModelo.php para poder instanciar el modelo de autores

 if($_SERVER['REQUEST_METHOD']=== 'POST'){
    $usu_codigo = $_POST['usu_codigo'];

    try{
        $conn = Database::getConnection();
        $UsuarioModelo = new RegistrarUsuarioModelo($conn);
        if($UsuarioModelo->eliminarUsuarios($usu_codigo)){
            header("Location: ../index.php?page=admin/RegistrarUsuario");
            exit();
        }else{
            header("Location: ../index.php?page=admin/RegistrarUsuario&error=" . urlencode("Error al actualizar el autor"));
            exit();
        }
    }catch(Exception $e){
        echo json_encode(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
    }
    exit();
}
?>
<?php
 require_once($_SERVER['DOCUMENT_ROOT'] . '/ProyectoFinalMulti/config/database.php');// Incluir el archivo Database.php para poder instanciar la conexión
 require_once($_SERVER['DOCUMENT_ROOT'] . '/ProyectoFinalMulti/models/RegistrarUsuarioModelo.php');// Incluir el archivo autorModelo.php para poder instanciar el modelo de autores

if($_SERVER['REQUEST_METHOD']=== 'POST'){
    $usu_codigo = $_POST['usu_codigo'];
    $usu_nombre = $_POST['usu_nombre'];
    $usu_apellido = $_POST['usu_apellido'];
    $usu_correo = $_POST['usu_correo'];
    $usu_usuario = $_POST['usu_usuario'];
    $usu_curso = $_POST['usu_curso'];
    $usu_modalidad = $_POST['usu_modalidad'];
    $usu_cedula = $_POST['usu_cedula'];
    $usu_telefono = $_POST['usu_telefono'];
    

    if(empty($usu_codigo) || empty($usu_nombre) || empty($usu_apellido) || empty($usu_correo) || empty($usu_usuario) || empty($usu_curso) || empty($usu_modalidad) || empty($usu_cedula) || empty($usu_telefono)){
        header("Location: ../index.php?page=admin/RegistrarUsuario&error=" . urlencode("Todos los campos son obligatorios"));
        exit();
    }

    try{
        $conn = Database::getConnection();
        $usuarioModelo = new RegistrarUsuarioModelo($conn);
        if($usuarioModelo->actualizarUsuarios($usu_codigo, $usu_nombre, $usu_apellido, $usu_correo, $usu_usuario, $usu_curso, $usu_modalidad, $usu_cedula, $usu_telefono)){
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
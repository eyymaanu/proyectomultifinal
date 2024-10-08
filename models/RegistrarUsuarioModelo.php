<?php
require_once '../config/database.php'; // Incluir el archivo Database.php para poder instanciar la conexión
class RegistrarUsuarioModelo {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
 
    public function register($nombre, $apellido, $correo, $telefono, $modalidad, $curso, $cedula, $role, $contrasena,$usuario) {
        // Encriptar la contraseña
        $contrasenaEncriptada = encriptarCadena($contrasena);

        // Preparar la consulta para insertar el nuevo usuario
        $stmt = $this->db->prepare("INSERT INTO usuarios (usu_nombre, usu_apellido, usu_correo, usu_telefono, usu_modalidad, usu_curso, usu_cedula, usu_role, usu_contrasena,usu_usuario) VALUES (:nombre, :apellido, :correo, :telefono, :modalidad, :curso, :cedula, :role, :contrasena, :usuario)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':modalidad', $modalidad);
        $stmt->bindParam(':curso', $curso);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':contrasena', $contrasenaEncriptada);
        $stmt->bindParam(':usuario',$usuario); // Bind para la contraseña

        // Ejecutar la consulta y verificar si se registró exitosamente
        return $stmt->execute(); // Retorna el resultado de la ejecución
    }
    

    public function actualizarUsuarios($usu_codigo, $usu_nombre, $usu_apellido, $usu_correo, $usu_usuario, $usu_curso, $usu_modalidad, $usu_cedula, $usu_telefono){
        $stmt = $this->db->prepare("UPDATE usuarios SET usu_nombre = :nombre, usu_apellido = :apellido, usu_correo = :correo, usu_usuario = :usuario, usu_curso = :curso, usu_modalidad = :modalidad, usu_cedula = :cedula, usu_telefono = :telefono WHERE usu_codigo = :codigo");
        $stmt->bindParam(':codigo', $usu_codigo);
        $stmt->bindParam(':nombre', $usu_nombre);
        $stmt->bindParam(':apellido', $usu_apellido);
        $stmt->bindParam(':correo', $usu_correo);
        $stmt->bindParam(':usuario', $usu_usuario);
        $stmt->bindParam(':curso', $usu_curso);
        $stmt->bindParam(':modalidad', $usu_modalidad);
        $stmt->bindParam(':cedula', $usu_cedula);
        $stmt->bindParam(':telefono', $usu_telefono);
        return $stmt->execute();

    }

    // Verificar si los datos ya existen
    public function verificarDuplicados($usu_usuario, $usu_telefono, $usu_correo, $usu_cedula) {
        $sql = "SELECT usu_usuario, usu_telefono, usu_correo, usu_cedula FROM usuarios WHERE usu_usuario = :usuario OR usu_telefono = :telefono OR usu_correo = :email OR usu_cedula = :cedula";
        $stmt = $this->db->prepare($sql); // Corrected $this->conn to $this->db
        $stmt->bindParam(':usuario', $usu_usuario); // Corrected bind_param to bindParam
        $stmt->bindParam(':telefono', $usu_telefono); // Corrected bind_param to bindParam
        $stmt->bindParam(':email', $usu_correo); // Corrected bind_param to bindParam
        $stmt->bindParam(':cedula', $usu_cedula); // Corrected bind_param to bindParam
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Corrected get_result to fetch
        return $result !== false; // Retorna true si hay duplicados
    }
    public function eliminarUsuarios($usu_codigo) {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE usu_codigo = :codigo");
        $stmt->bindParam(':codigo', $usu_codigo);
        return $stmt->execute();
    }
}
?>
<?php
require_once '../config/database.php'; // Incluir el archivo Database.php para poder instanciar la conexión
class autorModelo {
    private $db;
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    function agregarAutor($nombre) {
        // Preparar la consulta
        $stmt = $this->db->prepare("INSERT INTO autores (Autor_nombre) VALUES (:autorNombre)");
        $stmt->bindParam(':autorNombre', $nombre);
        return $stmt->execute(); // Retorna el resultado de la ejecución
    }

    function obtenerAutores() {
        $stmt = $this->db->prepare("SELECT * FROM autores");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function actualizarAutor($id, $nombre) {
        $stmt = $this->db->prepare("UPDATE autores SET Autor_nombre = :nombre WHERE Autores_id = :id");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    function eliminarAutor($id) {
        $stmt = $this->db->prepare("DELETE FROM autores WHERE Autores_id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
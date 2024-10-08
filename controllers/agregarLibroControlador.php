<?php
require_once '../config/database.php'; // Incluir el archivo Database.php para poder instanciar la conexión
require_once '../models/libroModelo.php'; // Incluir el archivo libroModelo.php para poder instanciar el modelo de libros

class LibroControlador {
    private $db;
    
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['lib_titulo'];
    $autor = $_POST['lib_autor'];
    $categoria = $_POST['lib_categoria'];
    $cantidad = $_POST['lib_cantidad_real'];
    $stock = $_POST['lib_stock_real'];

    // Validar si se ha subido una imagen
    if (isset($_FILES['lib_img']) && $_FILES['lib_img']['error'] === UPLOAD_ERR_OK) {
        $rutaTemporal = $_FILES['lib_img']['tmp_name'];

        // Leer el contenido del archivo de imagen en formato binario
        $imagenBinaria = file_get_contents($rutaTemporal);

        // Crear conexión y guardar el libro en la base de datos
        $conn = Database::getConnection();
        $libroModelo = new LibroModelo($conn);

if ($libroModelo->verificarDuplicados($titulo)) {
            header("Location: ../index.php?page=admin/AgregarLibro&error=" . urlencode("El libro ya está registrado."));
            exit();
        }else if ($libroModelo->agregarLibro($titulo, $autor, $categoria, $imagenBinaria, $cantidad, $stock)) {
            header("Location: ../index.php?page=admin/AgregarLibro&success=" . urlencode("Libro registrado correctamente."));
            exit();
        } else {
            $error = "Error al registrar el libro.";
        }
    } else {
        $error = "No se ha subido una imagen válida.";
    }

    // Si hay algún error, redirigir con mensaje de error
    header("Location: ../index.php?page=admin/agregarLibro&error=" . urlencode($error));
    exit();
}

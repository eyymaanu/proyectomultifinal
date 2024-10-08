<?php
 require_once '../config/database.php' ;// Incluir el archivo Database.php para poder instanciar la conexión
 $conn = Database::getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lib_codigo = $_POST['lib_codigo'];
    $lib_titulo = $_POST['lib_titulo'];
    $lib_autor_codigo = $_POST['lib_autor_codigo'];
    $lib_categoria = $_POST['lib_categoria'];
    $lib_cantidad_real = $_POST['lib_cantidad_real'];
    $lib_stock_real = $_POST['lib_stock_real'];

    // Validar y procesar la imagen
    if (isset($_FILES['lib_img']) && $_FILES['lib_img']['error'] === UPLOAD_ERR_OK) {
        // Si se ha subido una nueva imagen
        $imgData = file_get_contents($_FILES['lib_img']['tmp_name']);
    } else {
        // Si no se ha subido una nueva imagen, conservar la imagen actual
        $imgData = $_POST['lib_img_actual'];
        
        if (empty($imgData)) {
            // Si no hay datos en lib_img_actual, usar una imagen por defecto
            $defaultImagePath = $_SERVER['DOCUMENT_ROOT'] . './assets/images/fondo.jpg'; // Cambia esto a la ruta de tu imagen por defecto
            $imgData = file_get_contents($defaultImagePath);
            
            if ($imgData === false) {
                echo "No se ha proporcionado una imagen actual y no se pudo cargar la imagen por defecto.";
                exit();
            }
        }
    }

    $sql = "UPDATE libros SET lib_titulo = :lib_titulo, lib_autor_codigo = :lib_autor_codigo, lib_categoria = :lib_categoria, lib_img = :lib_img, lib_cantidad_real = :lib_cantidad_real, stock_actual = :stock_actual WHERE lib_codigo = :lib_codigo";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':lib_titulo', $lib_titulo);
    $stmt->bindParam(':lib_autor_codigo', $lib_autor_codigo);
    $stmt->bindParam(':lib_categoria', $lib_categoria);
    $stmt->bindParam(':lib_img', $imgData, PDO::PARAM_LOB);
    $stmt->bindParam(':lib_cantidad_real', $lib_cantidad_real);
    $stmt->bindParam(':stock_actual', $lib_stock_real);
    $stmt->bindParam(':lib_codigo', $lib_codigo);

    if ($stmt->execute()) {
        header('Location: ../index.php?page=admin/AgregarLibro');
    } else {
       header('Location: ../index.php?page=admin/AgregarLibro&error=' . urlencode('Error al actualizar el libro'));
    }
}
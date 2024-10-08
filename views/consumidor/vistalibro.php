<?php
require_once './config/database.php'; // Incluir el archivo Database.php


// Conexión a la base de datos
$pdo = Database::getConnection();

// Recibir el ID del libro desde la URL
if (isset($_GET['id'])) {
    $libro_id = $_GET['id'];

    // Consulta para obtener solo el libro seleccionado
    $stmt = $pdo->prepare("SELECT * FROM libros WHERE lib_codigo = ?");
    $stmt->execute([$libro_id]);
    $libro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$libro) {
        echo "Libro no encontrado.";
        exit;
    }

    // Obtener datos del libro
    $imagen_base64 = base64_encode($libro['lib_img']);
    $imagen_src = 'data:image/jpeg;base64,' . $imagen_base64;
    $porcentaje_stock = ($libro['stock_actual'] / $libro['lib_cantidad_real']) * 100;

    // Obtener el nombre del autor
    $autor_codigo = $libro['lib_autor_codigo'];
    $stmt_autor = $pdo->prepare("SELECT Autor_nombre FROM autores WHERE Autores_id = :codigo");
    $stmt_autor->bindParam(':codigo', $autor_codigo, PDO::PARAM_INT);
    $stmt_autor->execute();
    $autor = $stmt_autor->fetch(PDO::FETCH_ASSOC);
    $autor_nombre = $autor ? $autor['Autor_nombre'] : 'Desconocido';
} else {
    echo "ID de libro no proporcionado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css");

    body {
        background-color: #f8f9fa;
    }

    .card {
        border: none;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .product-image-container {
        overflow: hidden;
        height: auto;
        width: 100%;
        max-width: 300px; /* Define un ancho máximo */
        margin: 0 auto;
    }

    .product-image-container img {
        transition: transform 0.3s ease;
        object-fit: contain; /* Ajusta la imagen para que se mantenga contenida y proporcional */
        width: 100%;
        height: auto; /* Asegura que la imagen mantenga sus proporciones */
    }

    .product-image-container:hover img {
        transform: scale(1.05);
    }

    .btn-check:checked+.btn-outline-primary,
    .btn-check:checked+.btn-outline-danger,
    .btn-check:checked+.btn-outline-success {
        color: #fff;
    }

    #addToCartBtn {
        transition: all 0.3s ease;
    }

    #addToCartBtn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 767.98px) {
        .card-body {
            padding: 1.5rem;
        }

        .product-image-container {
            max-width: 200px; /* Ajustar el tamaño de la imagen en pantallas pequeñas */
        }
    }

    .ratings i {
        font-size: 1.2rem;
    }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="card shadow">
            <div class="row g-0">
                <div class="col-md-6">
                    <div class="product-image-container">
                        <img src="<?= $imagen_src ?>" class="img-fluid rounded-start" alt="Imagen del libro">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h2 class="card-title"><?= htmlspecialchars($libro['lib_titulo']) ?></h2>
                        <p class="card-text">Autor: <?= htmlspecialchars($autor_nombre) ?></p>
                        <p class="card-text">Categoría: <?= htmlspecialchars($libro['lib_categoria']) ?></p>
                        <p class="card-text"><strong>Stock: <?= htmlspecialchars($libro['stock_actual']) ?></strong></p>

                        <!-- Selección de cantidad -->
                        <div class="mb-3">
                            <label for="cantidadSelect" class="form-label">Cantidad a reservar:</label>
                            <select class="form-select" id="cantidadSelect" aria-label="Selección de cantidad">
                                <?php for ($i = 1; $i <= $libro['stock_actual']; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <!-- Barra de progreso -->
                        <div class="mb-3">
                            <label for="stockProgress" class="form-label">Disponibilidad de stock:</label>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: <?= $porcentaje_stock ?>%;" aria-valuenow="<?= $libro['stock_actual'] ?>" aria-valuemin="0" aria-valuemax="<?= $libro['lib_cantidad_real'] ?>">
                                    <?= round($porcentaje_stock, 2) ?>%
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-lg w-100 mb-3" id="reservarBtn">Reservar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

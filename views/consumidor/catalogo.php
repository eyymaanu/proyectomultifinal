<?php 
// Conectarse a la base de datos
require_once './config/database.php';


// Crear una instancia de conexión
$conn = Database::getConnection();

// Consultar los datos de los libros
$sql = "SELECT lib_codigo, lib_titulo, lib_autor_codigo, lib_img, lib_categoria, lib_cantidad_real, stock_actual FROM libros"; 
$stmt = $conn->query($sql);
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrador</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            background-color: hsla(237.7539960075827, 100%, 50%, 1);
            background-image: radial-gradient(circle at 0% 99%, hsla(237.7539960075827, 100%, 50%, 1) 0%, transparent 67%), radial-gradient(circle at 46% 94%, hsla(14.588235294117649, 0%, 0%, 1) 0%, transparent 81%), radial-gradient(circle at 93% 95%, hsla(256.2834077722886, 100%, 23%, 1) 0%, transparent 66%), radial-gradient(circle at 89% 8%, hsla(253.469387755102, 100%, 9%, 1) 0%, transparent 150%);
            background-blend-mode: normal, normal, normal, normal;
        }

        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            height: 350px;
            object-fit: cover;
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #218838;
        }

        .modal-content {
            border-radius: 0.5rem;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal.show .modal-dialog {
            animation: fadeIn 0.3s ease-out;
        }

        @media (max-width: 767.98px) {
            .card-img-top {
                height: 150px;
            }
        }
        .card-link {
            text-decoration: none;
            color: inherit;
        }
        .card-link:hover {
            text-decoration: none;
            color: inherit;
        }

    </style>
</head>

<body>

<div class="fondo container my-5">
    <h1 class="text-center mb-5">Product Catalog</h1>
    <div class="row" id="productList">

        <?php if (count($libros) > 0): ?>
            <?php foreach ($libros as $libro): ?>
                <div class="col-md-6 col-lg-4 mb-4">

                    <a class="card-link" href="index.php?page=consumidor/vistalibro&id=<?= $libro['lib_codigo']; ?>">
                        <div class="card h-100 shadow-sm">
                            <!-- Convertir la imagen binaria a base64 -->
                        <?php 
                        $imagen_base64 = base64_encode($libro['lib_img']); // Convertir binario a base64
                        $tipo_mime = 'image/png'; // Asumimos que es PNG, cambia si es necesario
                        ?>
                        <img src="data:<?php echo $tipo_mime; ?>;base64,<?php echo $imagen_base64; ?>" class="card-img-top" alt="<?php echo $libro['lib_titulo']; ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $libro['lib_titulo']; ?></h5>
                            
                            <?php
                            // Obtener el nombre del autor basado en el código del autor
                            $autor_codigo = $libro['lib_autor_codigo'];
                            $sql_autor = "SELECT Autor_nombre FROM autores WHERE Autores_id = :codigo";
                            $stmt_autor = $conn->prepare($sql_autor);
                            $stmt_autor->bindParam(':codigo', $autor_codigo, PDO::PARAM_INT);
                            $stmt_autor->execute();
                            $autor = $stmt_autor->fetch(PDO::FETCH_ASSOC);
                            $autor_nombre = $autor ? $autor['Autor_nombre'] : 'Desconocido';
                            ?>
                            <p class="card-text">Autor: <?php echo $autor_nombre; ?></p>
                            <p class="card-text">Categoría: <?php echo $libro['lib_categoria']; ?></p>
                            <p class="card-text"><strong>Stock: <?php echo $libro['stock_actual']; ?></strong></p> 
                        </a>
                            <div class="mt-auto">
                                <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#reserveModal" aria-label="Reservar <?php echo $libro['lib_titulo']; ?>">Reservar</button>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <p>No se encontraron libros en el catálogo.</p>
        <?php endif; ?>
        
    </div>
</div>

<!-- Aquí van los modales de reserva y alquiler que ya tienes definidos en tu código -->

</body>
</html>

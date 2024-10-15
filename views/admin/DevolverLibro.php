<?php
// procesar_devolucion.php
require_once "./config/database.php";
$pdo = Database::getConnection();
$sql = "SELECT c.devo_numero, c.devo_fecha, u.usu_usuario, l.lib_titulo, d.devo_cantidad,u.usu_nombre, u.usu_apellido, u.usu_telefono, u.usu_modalidad, u.usu_curso, c.devo_fecha
        FROM devolucion_cab c
        JOIN devolucion_detalles d ON c.devo_numero = d.devo_codigonum
        JOIN usuarios u ON c.devo_usu_codigo = u.usu_codigo
        JOIN libros l ON d.devo_libros_codigo = l.lib_codigo"; // Asegúrate de que los nombres de columnas y tablas son correctos


$result = $pdo->query($sql);
$devoluciones = $result->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devolver Libros</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .container {
            margin-top: 40px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            font-weight: bold;
            color: #343a40;
        }

        .table-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .btn-sm {
            margin-right: 5px;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .fondo {
            background-color: hsla(201, 0%, 0%, 1);
            background-image: radial-gradient(circle at 53% 47%, hsla(172.0588235294118, 100%, 15%, 0.46) 12.234752994669636%, transparent 52.264096832990425%), radial-gradient(circle at 0% 50%, hsla(248.51427637118405, 100%, 13%, 1) 19.036690230222092%, transparent 50%);
            background-blend-mode: normal;
        }
    </style>
</head>

<body class="fondo">

<div class="container">
    <div class="table-container">
    <h1>Devolver Libros</h1>
        <h3>Devoluciones</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Modalidad</th>
                    <th>Curso</th>
                    <th>Libro</th>
                    <th>Cantidad</th>
                    <th>Fecha de Devolución</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar las devoluciones
                if (!empty($devoluciones)) {
                    foreach ($devoluciones as $devolucion) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($devolucion['usu_nombre']) . '</td>';
                        echo '<td>' . htmlspecialchars($devolucion['usu_apellido']) . '</td>';
                        echo '<td>' . htmlspecialchars($devolucion['usu_modalidad']) . '</td>';
                        echo '<td>' . htmlspecialchars($devolucion['usu_curso']) . '</td>';
                        echo '<td>' . htmlspecialchars($devolucion['lib_titulo']) . '</td>';
                        echo '<td>' . htmlspecialchars($devolucion['devo_cantidad']) . '</td>';
                        echo '<td>' . htmlspecialchars($devolucion['devo_fecha']) . '</td>'; 
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5" class="text-center">No hay devoluciones disponibles</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

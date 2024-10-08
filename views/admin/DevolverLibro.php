<?php $content = 'base.php'; ?>

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
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .btn-sm {
            margin-right: 5px;
        }

        /* Botones con estilo */
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        .fondo{
            background-color: hsla(201, 0%, 0%, 1);
    background-image: radial-gradient(circle at 53% 47%, hsla(172.0588235294118, 100%, 15%, 0.46) 12.234752994669636%, transparent 52.264096832990425%), radial-gradient(circle at 0% 50%, hsla(248.51427637118405, 100%, 13%, 1) 19.036690230222092%, transparent 50%), radial-gradient(circle at 4% 10%, hsla(255.44117647058818, 0%, 0%, 1) 11.730126878761642%, transparent 50%), radial-gradient(circle at 80% 50%, hsla(255.44117647058818, 0%, 0%, 1) 0%, transparent 50%), radial-gradient(circle at 80% 0%, hsla(242.2058823529412, 100%, 28%, 1) 0%, transparent 50%), radial-gradient(circle at 0% 100%, hsla(0, 0%, 29%, 0) 0%, transparent 50%), radial-gradient(circle at 80% 100%, hsla(0, 0%, 10%, 0) 0%, transparent 50%), radial-gradient(circle at 0% 0%, hsla(184.00000000000026, 10%, 14%, 0) 0%, transparent 50%);
    background-blend-mode: normal, normal, normal, normal, normal, normal, normal, normal;
}
    </style>
</head>
<body class="fondo">

<div class="container">
    <h1>Devolver Libros</h1>

    <!-- Tabla para mostrar devoluciones existentes -->
    <div class="table-container shadow-lg">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Número de Devolución</th>
                    <th>Fecha de Devolución</th>
                    <th>Código del Usuario</th>
                    <th>Cantidad de Libros</th>
                    <th>Código del Libro</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Aquí deberías incluir la lógica para recuperar los datos de la base de datos
                // Supongamos que tienes un método para obtener todas las devoluciones
                $devoluciones = []; // Reemplaza esto con la consulta a la base de datos

                foreach ($devoluciones as $devolucion) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($devolucion['devo_numero']) . '</td>';
                    echo '<td>' . htmlspecialchars($devolucion['devo_fecha']) . '</td>';
                    echo '<td>' . htmlspecialchars($devolucion['devo_usu_codigo']) . '</td>';
                    echo '<td>' . htmlspecialchars($devolucion['devo_cantidad']) . '</td>';
                    echo '<td>' . htmlspecialchars($devolucion['devo_libros_codigo']) . '</td>';
                    echo '<td class="text-end">';
                    echo '<a href="index.php?page=admin/EditarDevolucion&devo_numero=' . htmlspecialchars($devolucion['devo_numero']) . '" class="btn btn-warning btn-sm">Editar</a>';
                    echo '<a href="../proyectofinalmulti/controllers/devolucionControlador.php?action=eliminar&devo_numero=' . htmlspecialchars($devolucion['devo_numero']) . '" class="btn btn-danger btn-sm">Eliminar</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

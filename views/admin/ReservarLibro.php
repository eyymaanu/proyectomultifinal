<?php $content = 'base.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Libro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
    

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

        /* Botones con estilo similar */
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


  body {
    background-color: hsla(246, 32%, 17%, 1);
    background-image: radial-gradient(circle at 0% 99%, hsla(276, 100%, 51%, 1) 0%, transparent 67%), radial-gradient(circle at 46% 94%, hsla(263, 70%, 26%, 1) 0%, transparent 81%), radial-gradient(circle at 93% 95%, hsla(266, 100%, 22%, 1) 0%, transparent 66%), radial-gradient(circle at 89% 8%, hsla(246, 32%, 17%, 1) 0%, transparent 150%);
    background-blend-mode: normal, normal, normal, normal;
}
    </style>
</head>
<body>

<div class="container">
    <h1>Reservar Libro</h1>

    <!-- Tabla para mostrar reservas existentes -->
    <div class="table-container shadow-lg">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Número de Reserva</th>
                    <th>Fecha de Reserva</th>
                    <th>Código del Usuario</th>
                    <th>Cantidad de Libros</th>
                    <th>Código del Libro</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Aquí deberías incluir la lógica para recuperar los datos de la base de datos
                // Supongamos que tienes un método para obtener todas las reservas
                $reservas = []; // Reemplaza esto con la consulta a la base de datos

                foreach ($reservas as $reserva) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($reserva['res_numero']) . '</td>';
                    echo '<td>' . htmlspecialchars($reserva['res_fecha']) . '</td>';
                    echo '<td>' . htmlspecialchars($reserva['res_usu_codigo']) . '</td>';
                    echo '<td>' . htmlspecialchars($reserva['res_cantidad']) . '</td>';
                    echo '<td>' . htmlspecialchars($reserva['res_lib_codigo']) . '</td>';
                    echo '<td class="text-end">';
                    echo '<a href="index.php?page=admin/EditarReserva&res_numero=' . htmlspecialchars($reserva['res_numero']) . '" class="btn btn-warning btn-sm">Editar</a>';
                    echo '<a href="../proyectofinalmulti/controllers/reservaControlador.php?action=eliminar&res_numero=' . htmlspecialchars($reserva['res_numero']) . '" class="btn btn-danger btn-sm">Eliminar</a>';
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

<?php $content = 'base.php'; ?>

<?php
// Conectar a la base de datos
require_once "./config/database.php";
$pdo = Database::getConnection();
$query = " SELECT r.res_id, r.res_fecha, r.res_cantidad, r.estado, 
           u.usu_nombre, u.usu_correo, u.usu_telefono, u.usu_modalidad, u.usu_curso, 
           l.lib_titulo 
    FROM reservas r
    JOIN usuarios u ON r.res_usuario_id = u.usu_codigo
    JOIN libros l ON r.res_libro_id = l.lib_codigo
";

$stmt = $pdo->query($query);
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            background-color: rgba(255, 255, 255, 0.9); /* Fondo con opacidad */
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

        /* Estilos para botones */
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

        .fondo {
            background-color: hsla(201, 0%, 0%, 1);
            background-image: radial-gradient(circle at 53% 47%, hsla(172.0588235294118, 100%, 15%, 0.46) 12.234752994669636%, transparent 52.264096832990425%), radial-gradient(circle at 0% 50%, hsla(248.51427637118405, 100%, 13%, 1) 19.036690230222092%, transparent 50%), radial-gradient(circle at 4% 10%, hsla(255.44117647058818, 0%, 0%, 1) 11.730126878761642%, transparent 50%), radial-gradient(circle at 80% 50%, hsla(255.44117647058818, 0%, 0%, 1) 0%, transparent 50%), radial-gradient(circle at 80% 0%, hsla(242.2058823529412, 100%, 28%, 1) 0%, transparent 50%), radial-gradient(circle at 0% 100%, hsla(0, 0%, 29%, 0) 0%, transparent 50%), radial-gradient(circle at 80% 100%, hsla(0, 0%, 10%, 0) 0%, transparent 50%), radial-gradient(circle at 0% 0%, hsla(184.00000000000026, 10%, 14%, 0) 0%, transparent 50%);
            background-blend-mode: normal, normal, normal, normal, normal, normal, normal, normal;
        }
 
    
    </style>
</head>
<body class="fondo">
<div class="container mt-5">
    <h1>Reservas de Libros</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Modalidad</th>
                <th>Curso</th>
                <th>Libro</th>
                <th>Cantidad</th>
                <th>Fecha de reserva</th>
                <th>Fecha de devolución</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?= htmlspecialchars($reserva['usu_nombre']); ?></td>
                        <td><?= htmlspecialchars($reserva['usu_correo']); ?></td>
                        <td><?= htmlspecialchars($reserva['usu_telefono']); ?></td>
                        <td><?= htmlspecialchars($reserva['usu_modalidad']); ?></td>
                        <td><?= htmlspecialchars($reserva['usu_curso']); ?></td>
                        <td><?= htmlspecialchars($reserva['lib_titulo']); ?></td>
                        <td><?= htmlspecialchars($reserva['res_cantidad']); ?></td>
                        <td><?= htmlspecialchars($reserva['res_fecha']); ?></td>

                        <!-- Campo para introducir la fecha de devolución -->
                        <td>
                            <form action="views/admin/modificar_estado.php" method="POST">
                                <input type="hidden" name="reserva_id" value="<?= $reserva['res_id']; ?>">
                                <input type="datetime-local" name="fecha_devolucion" class="form-control" required>
                        </td>

                        <!-- Selección del estado de la reserva -->
                        <td>
                            <select name="estado" class="form-select">
                                <option value="pendiente" <?= $reserva['estado'] == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="cancelada" <?= $reserva['estado'] == 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                                <option value="completada" <?= $reserva['estado'] == 'completada' ? 'selected' : ''; ?>>Completada</option>
                            </select>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>

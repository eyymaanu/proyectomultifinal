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
</head>
<body>
<div class="container mt-5">
    <h1>Reservas de Libros</h1>
    <table class="table table-bordered">
        <thead>
            <tr>

                <th>Usuario</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>Modalidad</th>
                <th>Curso</th>
                <th>Libro</th>
                <th>Cantidad</th>
                <th>Fecha</th>
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
                        
                        <td>
                            <form action="views/admin/modificar_estado.php" method="POST">
                                <input type="hidden" name="reserva_id" value="<?= $reserva['res_id']; ?>">
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

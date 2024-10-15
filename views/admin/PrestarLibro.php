<?php 
$content = 'base.php';

// Conexión a la base de datos
$pdo = Database::getConnection();
 
// Obtener todos los préstamos activos (sin importar la fecha de devolución)
$stmt = $pdo->prepare("SELECT p.pre_codigo, p.pre_fecha, d.presd_cantidad, l.lib_titulo, p.pre_fechadev, 
                              u.usu_nombre, u.usu_apellido, u.usu_telefono, u.usu_modalidad
                        FROM prestamo_cab p
                        JOIN prestamos_detalles d ON p.pre_codigo = d.prest_codigonum
                        JOIN libros l ON d.presd_libros_codigo = l.lib_codigo
                        JOIN usuarios u ON p.presc_usu_codigo = u.usu_codigo
                        WHERE p.estado != 'Completado'"); // Mostrar todos los préstamos sin completar
$stmt->execute();
$prestamosActivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtlib = $pdo->prepare("SELECT lib_codigo, lib_titulo, stock_actual FROM libros WHERE stock_actual > 0");
$stmtlib->execute();
$libros = $stmtlib->fetchAll(PDO::FETCH_ASSOC);

// Obtener los usuarios
$stmtusu = $pdo->prepare("SELECT usu_codigo, usu_nombre, usu_apellido, usu_correo, usu_cedula, usu_usuario FROM usuarios");
$stmtusu->execute();
$usuarios = $stmtusu->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préstamos Activos y Vencidos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    h1,
    h3 {
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

    .table th,
    .table td {
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

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .fondo {
        background-color: hsla(201, 0%, 0%, 1);
        background-image: radial-gradient(circle at 53% 47%, hsla(172.0588235294118, 100%, 15%, 0.46) 12.234752994669636%, transparent 52.264096832990425%), radial-gradient(circle at 0% 50%, hsla(248.51427637118405, 100%, 13%, 1) 19.036690230222092%, transparent 50%);
        background-blend-mode: normal, normal;
    }

    .section-title {
        text-align: center;
        margin-top: 40px;
        color: #343a40;
        font-weight: bold;
    }
    </style>
    <script>
    // Función para actualizar las opciones de cantidad según el stock disponible
    function actualizarCantidad() {
        const selectLibro = document.getElementById('libro');
        const selectCantidad = document.getElementById('cantidad');

        // Obtener el stock del libro seleccionado (valor almacenado en el atributo data-stock)
        const stockDisponible = selectLibro.options[selectLibro.selectedIndex].getAttribute('data-stock');

        // Limpiar las opciones existentes
        selectCantidad.innerHTML = '';

        // Agregar las opciones de cantidad según el stock disponible
        for (let i = 1; i <= stockDisponible; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            selectCantidad.appendChild(option);
        }
    }

    // Función para mostrar detalles del usuario seleccionado
    function mostrarDetallesUsuario() {
        const selectUsuario = document.getElementById('usuario');
        const detallesDiv = document.getElementById('detallesUsuario');

        // Obtener el usuario seleccionado
        const usuarioSeleccionado = selectUsuario.options[selectUsuario.selectedIndex];

        // Obtener los datos del usuario
        const nombre = usuarioSeleccionado.getAttribute('data-nombre');
        const apellido = usuarioSeleccionado.getAttribute('data-apellido');
        const cedula = usuarioSeleccionado.getAttribute('data-cedula');
        const username = usuarioSeleccionado.getAttribute('data-username');
        const email = usuarioSeleccionado.getAttribute('data-email');
        // Mostrar detalles
        detallesDiv.innerHTML = `
                <strong>Nombre:</strong> ${nombre} ${apellido}<br>
                <strong>Cédula:</strong> ${cedula}<br>
                <strong>Nombre de Usuario:</strong> ${username} <br>
                <strong>Correo:</strong> ${email}
            `;
    }
    </script>
</head>

<body class="fondo">
    <div class="table-container">
        <h1>Marcar Libro como Prestado</h1>
        <form id="registrationForm">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <select class="form-control" name="usu_codigo" id="usuario" onchange="mostrarDetallesUsuario()"
                    required>
                    <option value="">Seleccione un usuario</option>
                    <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= htmlspecialchars($usuario['usu_codigo']); ?>"
                        data-nombre="<?= htmlspecialchars($usuario['usu_nombre']); ?>"
                        data-apellido="<?= htmlspecialchars($usuario['usu_apellido']); ?>"
                        data-cedula="<?= htmlspecialchars($usuario['usu_cedula']); ?>"
                        data-username="<?= htmlspecialchars($usuario['usu_usuario']); ?>"
                        data-email="<?= htmlspecialchars($usuario['usu_correo']); ?>">
                        <?= htmlspecialchars($usuario['usu_nombre']) . ' ' . htmlspecialchars($usuario['usu_apellido']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <div id="detallesUsuario" class="mt-2"></div>
            </div>

            <div class="mb-3">
                <label for="libro" class="form-label">Libro:</label>
                <select class="form-control" name="lib_codigo" id="libro" onchange="actualizarCantidad()" required>
                    <option value="">Seleccione un libro</option>
                    <?php foreach ($libros as $libro): ?>
                    <option value="<?= htmlspecialchars($libro['lib_codigo']); ?>"
                        data-stock="<?= htmlspecialchars($libro['stock_actual']); ?>">
                        <?= htmlspecialchars($libro['lib_titulo']); ?> (Stock:
                        <?= htmlspecialchars($libro['stock_actual']); ?>)
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad a prestar:</label>
                <select class="form-control" name="cantidad" id="cantidad" required>
                    <option value="">Seleccione una cantidad</option>
                    <!-- Las opciones se agregarán dinámicamente -->
                </select>
            </div>

            <div class="mb-3">
                <label for="fechadev" class="form-label">Fecha de Devolución:</label>
                <input type="datetime-local" class="form-control" id="fechadev" name="fecha_devolucion" required>
            </div>

            <button type="submit" class="btn btn-primary">Prestar Libro</button>
        </form>

        <div id="successMessage" class="alert alert-success" role="alert" style="display:none;">
            Se ha Registrado Correctamente el prestamo.
        </div>
        <div id="errorMessage" class="alert alert-danger" role="alert" style="display:none;">
            Ocurrió un error al registrar el préstamo.
        </div>

        <!-- Spinner de carga -->
        <div id="loadingSpinner" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Enviando...</span>
            </div>
            <p>Enviando...</p>
        </div>




    </div>
    <div class="table-container">
    <!-- Tabla para préstamos activos -->
    <h3>Préstamos Activos</h3>
    <?php if (empty($prestamosActivos)): ?>
    <p>No hay préstamos activos.</p>
    <?php else: ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Modalidad</th>
                <th>Telefono</th>
                <th>Libro</th>
                <th>Cantidad</th>
                <th>Fecha de Préstamo</th>
                <th>Fecha de Devolución</th>
                <th>Devolver</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prestamosActivos as $prestamo): ?>
            <tr>
                <td><?= htmlspecialchars($prestamo['usu_nombre']) ?></td>
                <td><?= htmlspecialchars($prestamo['usu_apellido']) ?></td>
                <td><?= htmlspecialchars($prestamo['usu_modalidad']) ?></td>
                <td><?= htmlspecialchars($prestamo['usu_telefono']) ?></td>
                <td><?= htmlspecialchars($prestamo['lib_titulo']) ?></td>
                <td><?= htmlspecialchars($prestamo['presd_cantidad']) ?></td>
                <td><?= htmlspecialchars($prestamo['pre_fecha']) ?></td>
                <td><?= htmlspecialchars($prestamo['pre_fechadev'] ?? 'Sin fecha') ?></td>
                <td>
                    <form action= "./controllers/devolucion.php" id="devForm" method="POST">
                        <button type="submit" id="btnDev" class="btn btn-warning btn-sm" name="devolver" value="">Devolver</button>
                        <input type="hidden" name="prestamo_id" value="<?= htmlspecialchars($prestamo['pre_codigo']) ?>">
                    </form>
                </td>
                
        <div id="successMessag" class="alert alert-success" role="alert" style="display:none;">
            Se ha Registrado Correctamente la devolución.
        </div>
        <div id="errorMessag" class="alert alert-danger" role="alert" style="display:none;">
            Ocurrió un error al registrar la devolución.
        </div>

        <!-- Spinner de carga -->
        <div id="loadingSpinne" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Enviando...</span>
            </div>
            <p>Enviando...</p>
        </div>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

    <!-- Tabla para préstamos vencidos -->


    <div class="table-container">

        <h3 class="section-title">Préstamos Vencidos</h3>
        <?php
// Obtener los préstamos vencidos
$stmtVencidos = $pdo->prepare("
    SELECT 
        p.pre_codigo, 
        p.pre_fecha, 
        d.presd_cantidad, 
        l.lib_titulo, 
        p.pre_fechadev, 
        u.usu_nombre, 
        u.usu_apellido, 
        u.usu_telefono, 
        u.usu_modalidad
    FROM 
        prestamo_cab p
    JOIN 
        prestamos_detalles d ON p.pre_codigo = d.prest_codigonum
    JOIN 
        libros l ON d.presd_libros_codigo = l.lib_codigo
    JOIN 
        usuarios u ON p.presc_usu_codigo = u.usu_codigo
    WHERE 
        p.pre_fechadev < CURRENT_TIMESTAMP 
        AND p.estado != 'Completado'
");
$stmtVencidos->execute();
$prestamosVencidos = $stmtVencidos->fetchAll(PDO::FETCH_ASSOC);

// Mostrar en una tabla
if ($prestamosVencidos): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Modalidad</th>
                <th>Título del Libro</th>
                <th>Cantidad</th>
                <th>Fecha de Préstamo</th>
                <th>Fecha de Devolución</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prestamosVencidos as $prestamoVencido): ?>
                <tr>
                <td><?= htmlspecialchars($prestamoVencido['usu_nombre']) ?></td>
                    <td><?= htmlspecialchars($prestamoVencido['usu_apellido']) ?></td>
                    <td><?= htmlspecialchars($prestamoVencido['usu_telefono']) ?></td>
                    <td><?= htmlspecialchars($prestamoVencido['usu_modalidad']) ?></td>
                    <td><?= htmlspecialchars($prestamoVencido['lib_titulo']) ?></td>
                    <td><?= htmlspecialchars($prestamoVencido['presd_cantidad']) ?></td>
                    <td><?= htmlspecialchars($prestamoVencido['pre_fecha']) ?></td>
                    <td><?= htmlspecialchars($prestamoVencido['pre_fechadev']) ?></td>
                    </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No hay préstamos vencidos.</p>
<?php endif; ?>

</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
<script>
   
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

    // Mostrar el spinner de carga
    document.getElementById('loadingSpinner').style.display = 'block';
    document.getElementById('successMessage').style.display = 'none';
    document.getElementById('errorMessage').style.display = 'none';

    // Obtener los datos del formulario
    const formData = new FormData(this);

    // Enviar los datos al controlador usando fetch
    fetch('./controllers/PrestamosControlador.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Ocultar el spinner
            document.getElementById('loadingSpinner').style.display = 'none';

            // Mostrar mensaje basado en la respuesta
            if (data.success) {
                document.getElementById('successMessage').style.display = 'block';
                document.getElementById('successMessage').textContent = data.message;
                setTimeout(function() {
                    window.location.href = './index.php?page=admin/PrestarLibro';
                }, 500);
            } else {
                document.getElementById('errorMessage').style.display = 'block';
                document.getElementById('errorMessage').textContent = data.message;
            }
        })
        .catch(error => {
            // Ocultar el spinner
            document.getElementById('loadingSpinner').style.display = 'none';

            // Mostrar mensaje de error
            document.getElementById('errorMessage').style.display = 'block';
            document.getElementById('errorMessage').textContent = 'Ocurrió un error inesperado';
        });
});



</script>
</body>
            

</html>
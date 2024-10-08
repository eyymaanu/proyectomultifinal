<?php 

$content = 'base.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Autores - Administrador</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .form-container {
            margin-top: 40px;
            border-radius: 1rem;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table-container {
            margin-top: 40px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .table-striped tbody tr:hover {
            background-color: #f8f9fa;
        }

        h2 {
            text-align: center;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 20px;
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
    <div class="form-container shadow-lg">
        <h2>Agregar Autor</h2>
        <form id="autorform">
            <div class="form-group">
                <label for="Nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="autor_nombre" required>
            </div>
            
            <div class="text-center mt-4 mb-2">
                <button type="submit" class="btn btn-primary">Agregar Autor</button>
            </div>
        </form>
           <!-- Mensaje de éxito o error -->
           <div id="successMessage" class="alert alert-success" role="alert" style="display:none;">
            Se ha enviado el correo de restablecimiento de contraseña correctamente.
        </div>
        <div id="errorMessage" class="alert alert-danger" role="alert" style="display:none;">
            Ocurrió un error al enviar el correo. Por favor, inténtalo de nuevo.
        </div>

        <!-- Spinner de carga -->
        <div id="loadingSpinner" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Enviando...</span>
            </div>
            <p>Enviando...</p>
        </div>
    </div>

    

<div class="table-container shadow-lg mt-5">
    <h2>Lista de Autores</h2>
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nombre y Apellido</th>             
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
    require_once './config/database.php';
    $conn = Database::getConnection();
    $sql = "SELECT Autores_id, Autor_nombre FROM autores";
    $stmt = $conn->query($sql);
    $autores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($autores)) {

        foreach ($autores as $autor) {
            // Fila normal con el autor
            echo '<tr id="row-' . $autor['Autores_id'] . '">';
            echo '<td><span class="autor-nombre">' . htmlspecialchars($autor['Autor_nombre']) . '</span></td>';
            echo '<td class="text-end">
                    <button class="btn btn-warning btn-sm" onclick="editRow(' . $autor['Autores_id'] . ')">Editar</button>
                    <form method="POST" action="./controllers/delete.php" style="display:inline;">
                        <input type="hidden" name="Autores_id" value="' . $autor['Autores_id'] . '">
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                  </td>';
            echo '</tr>';
        
            // Fila de edición oculta
            echo '<tr id="edit-row-' . $autor['Autores_id'] . '" style="display:none;">';
            echo '<form method="POST" action="./controllers/editar.php">';
            echo '<input type="hidden" name="Autores_id" value="' . $autor['Autores_id'] . '">';
            echo '<td><input type="text" name="autor_nombre" class="form-control" value="' . htmlspecialchars($autor['Autor_nombre']) . '"></td>';

            echo '<td class="text-end">
                    <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="cancelEdit(' . $autor['Autores_id'] . ')">Cancelar</button>
                  </td>';
            echo '</form>';
            echo '</tr>';
        }
        } else {
            echo '<tr><td colspan="2" class="text-center">No hay autores registrados.</td></tr>';
        }
            ?>
        </tbody>
    </table>
</div>

            </tbody>
        </table>
        
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>
    function editRow(id) {
    document.getElementById(`row-${id}`).style.display = 'none';
    document.getElementById(`edit-row-${id}`).style.display = '';
}

function cancelEdit(id) {
    document.getElementById(`row-${id}`).style.display = '';
    document.getElementById(`edit-row-${id}`).style.display = 'none';
}

// Habilitar edición de los campos de textox|

document.getElementById('autorform').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del formulario
    
    // Mostrar el spinner de carga
    document.getElementById('loadingSpinner').style.display = 'block';
    document.getElementById('successMessage').style.display = 'none';
    document.getElementById('errorMessage').style.display = 'none';

    // Obtener los datos del formulario
    const formData = new FormData(this);

    // Enviar los datos al controlador usando fetch
    fetch('./controllers/autorControlador.php', {
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
            setTimeout(function () {
                    window.location.href = './index.php?page=admin/gestionarAutor';
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

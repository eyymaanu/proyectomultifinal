<?php
// Verificar si el usuario es un administrador

if (!isset($_SESSION['usu_role']) || $_SESSION['usu_role'] !== 1) {
    header("Location: ../proyectofinalmulti/index.php?page=auth/login"); // Redirigir si no es admin
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>


        .table-container {
            margin-top: 40px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            
            body {
    background-color: #f8f9fa;
    min-height: 100vh;
    align-items: center;
    }
    
    .card {
        border-radius: 1rem;
        border: none;
        
        }
        
        .form-control,
.form-select {
    border-radius: 0.5rem;
    border: 1px solid #ced4da;
    }
    
    .form-control:focus,
    .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        border-color: #86b7fe;
        }
        
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            transition: all 0.3s ease;
            }
            
            .btn-primary:hover {
                background-color: #0b5ed7;
                border-color: #0a58ca;
                transform: translateY(-2px);
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }
                
                
        @keyframes hero-gradient-animation {
    0% {
        --c-0: hsla(266.99999999999983, 1%, 12%, 1);
        --x-0: 85%;
        --y-0: 80%;
        --s-start-0: 9%;
        --s-end-0: 55%;
        --c-1: hsla(335.9999999999997, 2%, 22%, 1);
        --y-1: 24%;
        --s-start-1: 5%;
        --s-end-1: 72%;
        --x-1: 60%;
        --c-2: hsla(53.999999999999886, 0%, 0%, 0.49);
        --y-2: 82%;
        --x-2: 13%;
        --s-start-2: 5%;
        --s-end-2: 52%;
        --x-3: 24%;
        --s-start-3: 13%;
        --s-end-3: 68%;
        --y-3: 7%;
        --c-3: hsla(299, 4%, 36%, 1);
    }

    100% {
        --c-0: hsla(266.99999999999943, 0%, 12%, 1);
        --x-0: 31%;
        --y-0: 94%;
        --s-start-0: 9%;
        --s-end-0: 55%;
        --c-1: hsla(0, 4%, 19%, 1);
        --y-1: 25%;
        --s-start-1: 5%;
        --s-end-1: 72%;
        --x-1: 2%;
        --c-2: hsla(54.000000000000036, 0%, 0%, 0.49);
        --y-2: 20%;
        --x-2: 98%;
        --s-start-2: 5%;
        --s-end-2: 52%;
        --x-3: 95%;
        --s-start-3: 13%;
        --s-end-3: 68%;
        --y-3: 92%;
        --c-3: hsla(298.99999999999994, 3%, 41%, 1);
    }
}

@property --c-0 {
    syntax: '<color>';
    inherits: false;
    initial-value: hsla(266.99999999999983, 1%, 12%, 1)
}

@property --x-0 {
    syntax: '<percentage>';
    inherits: false;
    initial-value: 85%
}

@property --y-0 {
    syntax: '<percentage>';
    inherits: false;
    initial-value: 80%
}

@property --s-start-0 {
    syntax: '<percentage>';
    inherits: false;
    initial-value: 9%
}

@property --s-end-0 {
    syntax: '<percentage>';
    inherits: false;
    initial-value: 55%
}

@property --c-1 {
    syntax: '<color>';
    inherits: false;
    initial-value: hsla(335.9999999999997, 2%, 22%, 1)
}

@property --y-1 {
    syntax: '<percentage>';
    inherits: false;
    initial-value: 24%
}

@property --s-start-1 {
    syntax: '<percentage>';
    inherits: false;
    initial-value: 5%
}

@property --s-end-1 {
    syntax: '<percentage>';
    inherits: false;
    initial-value: 72%
}

@property --x-1 {
    syntax: '<percentage>';
    inherits: false;
    initial-value: 60%
}

@property --c-2 {
    syntax: '<color>';
    inherits: false;
    initial-value: hsla(53.999999999999886, 0%, 0%, 0.49)
}

@property --y-2 {
    syntax: '<percentage>';
    inherits: false;
    initial-value: 82%
}

@property --x-2 {
    syntax: '<percentage>';
    inherits: false;
    initial-value: 13%
}

@property --s-start-2 {
    syntax: '<percentage>';
    inherits: false;
    initial-value: 5%
}

@property --s-end-2 {
    syntax: '<percentage>';
    inherits: false;
    initial-value: 52%
}

@property --x-3 {
    syntax: '<percentage>';
    inherits: false;
    initial-value: 24%
}

@property --s-start-3 {
    syntax: '<percentage>';
    inherits: false;
    initial-value: 13%
}

@property --s-end-3 {
    syntax: '<percentage>';
    inherits: false;
    initial-value: 68%
}

@property --y-3 {
    syntax: '<percentage>';
    inherits: false;
    initial-value: 7%
}

@property --c-3 {
    syntax: '<color>';
    inherits: false;
    initial-value: hsla(299, 4%, 36%, 1)
}

body {
    --c-0: hsla(266.99999999999983, 1%, 12%, 1);
    --x-0: 85%;
    --y-0: 80%;
    --c-1: hsla(335.9999999999997, 2%, 22%, 1);
    --y-1: 24%;
    --x-1: 60%;
    --c-2: hsla(53.999999999999886, 0%, 0%, 0.49);
    --y-2: 82%;
    --x-2: 13%;
    --x-3: 24%;
    --y-3: 7%;
    --c-3: hsla(299, 4%, 36%, 1);
    ;
    background-color: hsla(0, 0%, 0%, 1);
    background-image: radial-gradient(circle at var(--x-0) var(--y-0), var(--c-0) var(--s-start-0), transparent var(--s-end-0)), radial-gradient(circle at var(--x-1) var(--y-1), var(--c-1) var(--s-start-1), transparent var(--s-end-1)), radial-gradient(circle at var(--x-2) var(--y-2), var(--c-2) var(--s-start-2), transparent var(--s-end-2)), radial-gradient(circle at var(--x-3) var(--y-3), var(--c-3) var(--s-start-3), transparent var(--s-end-3));
    animation: hero-gradient-animation 10s linear infinite alternate;
    background-blend-mode: normal, normal, normal, normal;
} 
 
 
.carta-body{
    padding: 2rem;
}


    </style>

    
</head>
<body>
    <div class="container mt-3" ">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg" >
                    <div class="card-body cartabody">
                        <h2 class="text-center mb-4">Formulario de Registro</h2>
                            <form id="registrationForm" >
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required pattern="[A-Za-z\s]+" maxlength="50" aria-label="Nombre">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" required pattern="[A-Za-z\s]+" maxlength="50" aria-label="Apellido">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Nombre de Usuario" required pattern="[A-Za-z0-9_]+" maxlength="50" aria-label="Nombre de Usuario">
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo" required maxlength="100" aria-label="Correo">
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required pattern="\d+" maxlength="15" aria-label="Teléfono">
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                    <select class="form-control" id="modalidad" name="modalidad" required>
                                    <option value="" disabled selected>Seleccione la modalidad</option>
                                    <option value="Informática">Informática</option>
                                    <option value="Electricidad">Electricidad</option>
                                    <option value="Administración">Administración</option>
                                    <option value="Contabilidad">Contabilidad</option>
                                    <option value="Diseño Grafico y Publicidad">Diseño Grafico y Publicidad</option>
                                    <option value="Mecanica Automotriz">Mecanica Automotriz</option>
                                    <option value="Mecenica General">Mecanica General</option>
                                    <option value="Mecatronica">Mecatronica</option>
                                    <option value="Salud">Salud</option>
                                    <option value="Ciencias Basicas T.M">Ciencias Basicas T.M</option>
                                    <option value="Ciencias Sociales T.M">Ciencias Sociales T.M</option>
                                    <option value="Letras y Artes T.M">Letras y Artes T.M</option>
                                    <option value="Ciencias Sociales T.T">Ciencas Sociales T.T</option>
                                    <option value="Letras y Artes T.T">Letras y Artes T.T</option>
                                </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                    <select class="form-control" id="curso" name="curso" required aria-label="curso">
                                    <option value="" disabled selected>Seleccione el Curso</option>
                                    <option value="1">Primero</option>
                                    <option value="2">Segundo</option>
                                    <option value="3">Tercero</option>
                                </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cédula" required pattern="\d{6,9}" maxlength="9" aria-label="Cédula">
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" required minlength="8" maxlength="50" aria-label="Contraseña">
                            </div>
                            <div class="mb-3">
                                <select class="form-control" id="role" name="role" required aria-label="Rol">
                                    <option value="" disabled selected>Seleccione un rol</option>
                                    <option value="2">Consumidor</option>
                                    <option value="1">Administrador</option>
                                </select>
                            </div>
                            <div class="d-grid gap-2 mt-4 mb-2">
                                <button class="btn btn-primary btn-lg" type="submit" id="submitBtn">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    Registrarse
                                </button>
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
                    </div>
                </div>
            </div>
        </div>
    </div>


   
<div class="table-container shadow-lg mt-5" style="background-color: rgba(237,231,225);">
    <h2>Lista de Usuarios</h2>
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
          
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Nombre de usuario</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Modalidad</th>
                    <th>Curso</th>
                    <th>Cedula</th>
                    <th class="text-end">Acciones</th>
                
            </tr>
        </thead>
        <tbody>
        <?php
    require_once "./config/database.php";
    $conn = Database::getConnection();
    $sql = "SELECT usu_codigo,usu_nombre, usu_apellido, usu_usuario,usu_correo, usu_telefono, usu_modalidad, usu_curso, usu_cedula FROM usuarios";
    $stmt = $conn->query($sql);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($usuarios)) {

        foreach ($usuarios as $usuario) {
            // Fila normal con el autor
            echo '<tr id="row-' . $usuario['usu_codigo'] . '">';
            echo '<td>' . htmlspecialchars($usuario['usu_nombre']) . '</td>';
            echo '<td>' . htmlspecialchars($usuario['usu_apellido']) . '</td>';
            echo '<td>' . htmlspecialchars($usuario['usu_usuario']) . '</td>';
            echo '<td>' . htmlspecialchars($usuario['usu_correo']) . '</td>';
            echo '<td>' . htmlspecialchars($usuario['usu_telefono']) . '</td>';
            echo '<td>' . htmlspecialchars($usuario['usu_modalidad']) . '</td>';
            echo '<td>' . htmlspecialchars($usuario['usu_curso']) . '</td>';
            echo '<td>' . htmlspecialchars($usuario['usu_cedula']) . '</td>';
            
            echo '<td class="text-end">
                    <button class="btn btn-warning btn-sm" onclick="editRow(' . $usuario['usu_codigo'] . ')">Editar</button>
                    <form method="POST" action="./controllers/deleteuser.php" style="display:inline;">
                        <input type="hidden" name="usu_codigo" value="' . $usuario['usu_codigo'] . '">
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                  </td>';
            echo '</tr>';
        
            // Fila de edición oculta
            echo '<tr id="edit-row-' . $usuario['usu_codigo'] . '" style="display:none;">';
            echo '<form method="POST" action="./controllers/editaruser.php">';
            echo '<input type="hidden" name="usu_codigo" value="' . $usuario['usu_codigo'] . '">';
            echo '<td><input type="text" name="usu_nombre" class="form-control" value="' . htmlspecialchars($usuario['usu_nombre']) . '"></td>';
            echo '<td><input type="text" name="usu_apellido" class="form-control" value="' . htmlspecialchars($usuario['usu_apellido']) . '"></td>';
            echo '<td><input type="text" name="usu_usuario" class="form-control" value="' . htmlspecialchars($usuario['usu_usuario']) . '"></td>';
            echo '<td><input type="email" name="usu_correo" class="form-control" value="' . htmlspecialchars($usuario['usu_correo']) . '"></td>';
            echo '<td><input type="text" name="usu_telefono" class="form-control" value="' . htmlspecialchars($usuario['usu_telefono']) . '"></td>';
            echo '<td><select name="usu_modalidad" class="form-control">
                    <option value="Informática"' . ($usuario['usu_modalidad'] == 'Informática' ? ' selected' : '') . '>Informática</option>
                    <option value="Electricidad"' . ($usuario['usu_modalidad'] == 'Electricidad' ? ' selected' : '') . '>Electricidad</option>
                    <option value="Administración"' . ($usuario['usu_modalidad'] == 'Administración' ? ' selected' : '') . '>Administración</option>
                    <option value="Contabilidad"' . ($usuario['usu_modalidad'] == 'Contabilidad' ? ' selected' : '') . '>Contabilidad</option>
                    <option value="Diseño Grafico y Publicidad"' . ($usuario['usu_modalidad'] == 'Diseño Grafico y Publicidad' ? ' selected' : '') . '>Diseño Grafico y Publicidad</option>
                    <option value="Mecanica Automotriz"' . ($usuario['usu_modalidad'] == 'Mecanica Automotriz' ? ' selected' : '') . '>Mecanica Automotriz</option>
                    <option value="Mecenica General"' . ($usuario['usu_modalidad'] == 'Mecenica General' ? ' selected' : '') . '>Mecanica General</option>
                    <option value="Mecatronica"' . ($usuario['usu_modalidad'] == 'Mecatronica' ? ' selected' : '') . '>Mecatronica</option>
                    <option value="Salud"' . ($usuario['usu_modalidad'] == 'Salud' ? ' selected' : '') . '>Salud</option>
                    <option value="Ciencias Basicas T.M"' . ($usuario['usu_modalidad'] == 'Ciencias Basicas T.M' ? ' selected' : '') . '>Ciencias Basicas T.M</option>
                    <option value="Ciencias Sociales T.M"' . ($usuario['usu_modalidad'] == 'Ciencias Sociales T.M' ? ' selected' : '') . '>Ciencias Sociales T.M</option>
                    <option value="Letras y Artes T.M"' . ($usuario['usu_modalidad'] == 'Letras y Artes T.M' ? ' selected' : '') . '>Letras y Artes T.M</option>
                    <option value="Ciencias Sociales T.T"' . ($usuario['usu_modalidad'] == 'Ciencias Sociales T.T' ? ' selected' : '') . '>Ciencias Sociales T.T</option>
                    <option value="Letras y Artes T.T"' . ($usuario['usu_modalidad'] == 'Letras y Artes T.T' ? ' selected' : '') . '>Letras y Artes T.T</option>
                  </select></td>';
            echo '<td><select name="usu_curso" class="form-control">
                    <option value="1"' . ($usuario['usu_curso'] == '1' ? ' selected' : '') . '>Primero</option>
                    <option value="2"' . ($usuario['usu_curso'] == '2' ? ' selected' : '') . '>Segundo</option>
                    <option value="3"' . ($usuario['usu_curso'] == '3' ? ' selected' : '') . '>Tercero</option>
                  </select></td>';
            echo '<td><input type="text" name="usu_cedula" class="form-control" value="' . htmlspecialchars($usuario['usu_cedula']) . '"></td>'; 
            echo '<td class="text-end">
                    <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="cancelEdit(' . $usuario['usu_codigo'] . ')">Cancelar</button>
                  </td>';
            echo '</form>';
            echo '</tr>';
        }
        
        } else {
            echo '<tr><td colspan="2" class="text-center">No hay Usuarios registrados.</td></tr>';
        }
 ?>
        </tbody>
    </table>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    

<script>
    /*Ver si Que no se repita los campos
document.getElementById('registrationForm').addEventListener('submit', async function(event) {
    event.preventDefault();
    
    let formData = new FormData(this);
    
    const response = await fetch('controllers//UsuarioControlador.php', {
        method: 'POST',
        body: formData,
    });
    
    const result = await response.json();
    
    if (!result.success) {
        alert(result.message); // Mostrar mensaje de error
    } else {
        alert(result.message); // Mostrar mensaje de éxito
        this.reset(); // Limpiar formulario si el registro fue exitoso
    }
});
*/


 function editRow(id) {
    document.getElementById(`row-${id}`).style.display = 'none';
    document.getElementById(`edit-row-${id}`).style.display = '';
}

function cancelEdit(id) {
    document.getElementById(`row-${id}`).style.display = '';
    document.getElementById(`edit-row-${id}`).style.display = 'none';
}





document.getElementById('registrationForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del formulario
    
    // Mostrar el spinner de carga
    document.getElementById('loadingSpinner').style.display = 'block';
    document.getElementById('successMessage').style.display = 'none';
    document.getElementById('errorMessage').style.display = 'none';

    // Obtener los datos del formulario
    const formData = new FormData(this);

    // Enviar los datos al controlador usando fetch
    fetch('./controllers/UsuarioControlador.php', {
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
                    window.location.href = './index.php?page=admin/RegistrarUsuario';
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



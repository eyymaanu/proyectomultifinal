<?php
if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    // Manejar el caso en que no se proporcione un token
    $token = null;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f7fa; /* Fondo suave */
        }

        .container {
            max-width: 400px; /* Ancho máximo */
            margin-top: 100px; /* Espaciado superior */
            padding: 20px;
            background-color: white; /* Fondo blanco */
            border-radius: 15px; /* Bordes redondeados */
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); /* Sombra */
        }

        h2 {
            margin-bottom: 30px; /* Espaciado debajo del título */
            color: #007bff; /* Color del título */
        }

        .btn-primary {
            background-color: #007bff; /* Color del botón */
            border: none; /* Sin borde */
            border-radius: 25px; /* Bordes redondeados */
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Color en hover */
        }

        .form-group label {
            font-weight: bold; /* Etiquetas en negrita */
        }

        .alert {
            margin-top: 20px; /* Espaciado superior para las alertas */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Restablecer Contraseña</h2>

        <div id="alert-container"></div>

        <form id="reset-form">
           

            <div class="form-group">
                <label for="nueva_contra">Nueva Contraseña</label>
                <input type="password" class="form-control" id="nueva_contra" name="nueva_contra" required>
            </div>

            <div class="form-group">
                <label for="confirmar_contra">Confirmar Nueva Contraseña</label>
                <input type="password" class="form-control" id="confirmar_contra" name="confirmar_contra" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Restablecer Contraseña</button>
        </form>

        <p class="mt-3 text-center">
            <a href="../auth/login.php" class="text-primary">Volver a Iniciar Sesión</a>
        </p>
    </div>

</body>

<script>
    // Captura el envío del formulario
    $('#reset-form').on('submit', function (event) {
        event.preventDefault(); // Evita que se recargue la página

        var nuevaContra = $('#nueva_contra').val();
        var confirmarContra = $('#confirmar_contra').val();
        var token = "<?php echo $token; ?>";

        // Validar que las contraseñas coincidan
        if (nuevaContra !== confirmarContra) {
            $('#alert-container').html('<div class="alert alert-danger">Las contraseñas no coinciden.</div>');
            return;
        }

        // Simular una petición AJAX
        $.ajax({
            url: '../../controllers/contrasenaOlvidadaControlador.php', // Ruta real del controlador
            type: 'POST',
            data: {
                token: token,
                nueva_contra: nuevaContra,
                confirmar_contra: confirmarContra
            },
            success: function (response) {
                try {
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.status === 'success') {
                        // Mostrar mensaje de éxito
                        $('#alert-container').html('<div class="alert alert-success">' + jsonResponse.message + '</div>');
                        
                        // Esperar 2 segundos y redirigir al login
                        setTimeout(function () {
                            window.location.href = '../auth/login.php';
                        }, 2000); // 2000 milisegundos = 2 segundos
                        
                    } else if (jsonResponse.status === 'error') {
                        // Mostrar mensaje de error
                        $('#alert-container').html('<div class="alert alert-danger">' + jsonResponse.message + '</div>');
                    }
                } catch (e) {
                    // Mostrar mensaje de error si la respuesta no es JSON válido
                    $('#alert-container').html('<div class="alert alert-danger">Respuesta inválida del servidor.</div>');
                    setTimeout(function () {
                    window.location.href = '../auth/login.php';
                }, 2000);
                }
            },
            error: function () {
                // Mostrar mensaje genérico si hay un error en la conexión
                $('#alert-container').html('<div class="alert alert-danger">Ocurrió un error al intentar restablecer la contraseña. Inténtalo de nuevo.</div>');
                setTimeout(function () {
                    window.location.href = '../auth/login.php';
                }, 2000);
            }
        });
    });
</script>

</html>

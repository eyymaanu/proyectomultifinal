<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos personalizados */
        body {
            background-color: #f8f9fa; /* Color de fondo suave */
        }

        .container {
            max-width: 400px; /* Ancho máximo del contenedor */
            margin-top: 100px; /* Margen superior para centrar el contenedor */
            padding: 20px;
            background-color: white; /* Color de fondo blanco */
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Sombra para el contenedor */
        }

        h2 {
            text-align: center; /* Centrar el título */
            margin-bottom: 20px; /* Espaciado debajo del título */
        }

        .message {
            text-align: center; /* Centrar el mensaje */
            margin-bottom: 20px; /* Espaciado debajo del mensaje */
            font-size: 16px; /* Tamaño de fuente */
            line-height: 1.5; /* Espaciado entre líneas */
        }

        .btn-custom {
            width: 100%; /* Botón ocupa todo el ancho */
            padding: 10px; /* Padding para el botón */
            font-size: 16px; /* Tamaño de fuente */
        }

        .alert {
            margin-top: 20px; /* Espacio superior para el mensaje */
        }

        .alert-success,
        .alert-danger {
            display: none; /* Ocultar inicialmente */
        }

        /* Estilo del spinner */
        #loadingSpinner {
            display: none; /* Ocultar inicialmente */
            text-align: center; /* Centrar el spinner */
            margin-top: 20px; /* Espaciado superior */
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Recuperar Contraseña</h2>
        <p class="message">Introduce tu correo electrónico asociado a tu cuenta y recibirás un enlace para restablecer tu contraseña.</p>
        <form id="recoveryForm">
            <div class="form-group">
                <label for="usu_email">Correo Electrónico:</label>
                <input type="email" id="usu_email" name="usu_email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-custom">Enviar</button>
        </form>

        <!-- Mensaje de éxito o error -->
        <div id="successMessage" class="alert alert-success" role="alert">
            Se ha enviado el correo de restablecimiento de contraseña correctamente.
        </div>
        <div id="errorMessage" class="alert alert-danger" role="alert">
            Ocurrió un error al enviar el correo. Por favor, inténtalo de nuevo.
        </div>

        <!-- Spinner de carga -->
        <div id="loadingSpinner">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Enviando...</span>
            </div>
            <p>Enviando...</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        // Captura el envío del formulario
        $('#recoveryForm').on('submit', function (event) {
            event.preventDefault(); // Evita que se recargue la página
            var email = $('#usu_email').val();

            // Mostrar el spinner mientras se procesa la solicitud
            $('#loadingSpinner').show();
            $('#successMessage').hide();
            $('#errorMessage').hide();

            // Simular una petición AJAX
            $.ajax({
                url: '../../controllers/AuthControlador.php', // Ruta real del controlador
                type: 'POST',
                data: { usu_email: email },

                success: function (response) {
                    try {
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.status === 'success') {
                            // Mostrar mensaje de éxito
                            $('#successMessage').text(jsonResponse.message).show();
                        } else if (jsonResponse.status === 'error') {
                            // Mostrar mensaje de error
                            $('#errorMessage').text(jsonResponse.message).show();
                        }
                    } catch (e) {
                        // Mostrar mensaje de error si la respuesta no es JSON válido
                        $('#errorMessage').text('Respuesta inválida del servidor.').show();
                    }
                },
                error: function () {
                    // Mostrar mensaje genérico si hay un error en la conexión
                    $('#errorMessage').text('Ocurrió un error al intentar enviar el correo. Inténtalo de nuevo.').show();
                },
                complete: function () {
                    // Ocultar el spinner al completar la solicitud
                    $('#loadingSpinner').hide();
                }
            });
        });
    </script>
</body>

</html>

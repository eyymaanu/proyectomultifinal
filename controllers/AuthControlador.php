
<?php
// Incluye la configuración de la base de datos y PHPMailer
include('../config/database.php');
include('../config/mail_config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura el correo electrónico del formulario
    $usu_email = $_POST['usu_email'];
    // Conectar a la base de datos
    $conn = Database::getConnection(); 
    // Consulta para verificar si el usuario existe
    try{

        $sql = "SELECT usu_codigo FROM usuarios WHERE usu_correo = :usu_email LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usu_email', $usu_email);
        $stmt->execute();
       
        // Comprobar si el usuario existe
        if ($stmt->rowCount()> 0) { 
            
            // Generar un token único para el restablecimiento de contraseña
         
        $token = bin2hex(random_bytes(50));

        // Guarda el token en la base de datos
        $updateSql = "UPDATE usuarios SET token = :token WHERE usu_correo = :usu_email";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':token', $token);
        $updateStmt->bindParam(':usu_email', $usu_email);
        $updateStmt->execute();
        
        // Configuración de PHPMailer
        $mail = getMailer(); // Llama a la función para obtener la configuración del mailer
        
        // Configuración del correo
        $mail->setFrom('bibliotecamulticaacupe@gmail.com', 'BilbiotecaMulti');
        $mail->addAddress($usu_email);
        $mail->isHTML(true);
        $mail->Subject = 'Restablecimiento de Contrasena';
        $reset_link = "https://localhost/proyectofinalmulti/views/auth/restablecerContrasena.php?token=$token";
        $mail->Body = "<html>
        <head>
        <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('../assets/images/1366_2000.jpg'); /* Cambia esto por la URL de tu imagen de fondo */
                background-size: cover;
                background-repeat: no-repeat;
                padding: 50px 0; /* Espaciado superior e inferior */
                }
                .container {
                    background-color: rgba(255, 255, 255, 0.5); /* Fondo blanco semi-transparente */
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                    padding: 20px;
                    max-width: 600px;
                    margin: auto;
                    }
                    h2 {
                        color: #333;
                        text-align: center;
                        }
                        p {
                            font-size: 16px;
                            line-height: 1.5;
                            text-align: center;
                            }
                            a {
                                background-color: #007bff;
                                color: white;
                                padding: 10px 15px;
                                text-decoration: none;
                                border-radius: 5px;
                                display: inline-block;
                                margin-top: 10px; /* Margen superior para el botón */
                                }
                                .textoxd{ 
                                color:white;
                                }
                                span{
                                color:white;
                                }

                                a:hover {
                                    background-color: #0056b3;
                                    }
                                    
                                    /* Estilos responsivos */
                                    @media only screen and (max-width: 600px) {
                                        .container {
                                            width: 90%; /* Ancho del contenedor en dispositivos pequeños */
                                            padding: 15px; /* Menos padding en dispositivos pequeños */
                                            }
                                            h2 {
                                                font-size: 20px; /* Ajustar el tamaño del texto en dispositivos pequeños */
                                                }
                                                p {
                                                    font-size: 14px; /* Ajustar el tamaño del texto en dispositivos pequeños */
                                                    }
                                                    a {
                                                        padding: 8px 12px; /* Ajustar el tamaño del botón en dispositivos pequeños */
                                                        color: white;
                                                        }
                                                        }
                                                        </style>
                                                        </head>
                                                        <body>
                                                        <div class='container'>
                                                        <h2>Restablecer su Contraseña</h2>
                                                        <p>Solicitud de Cambio de Contraseña provenienete de Biblioteca Multi</p>
                                                        <p>Haga clic en el siguiente enlace para restablecer su contraseña:</p>
                                                        <p style='color: white;'><a style='color: white;' class='textoxd' href='$reset_link'>Restablecer Contraseña</a></p>
                                                        <p>Si no solicitó un restablecimiento de contraseña, ignore este mensaje.</p>
                                                        <p>&#169;DonGatoYsuPandilla</p>
                                                        </div>
                                                        </body>
                                                        </html>
                                                        ";
                                                        $mail->send();
                                                        echo json_encode(['status'=>'success','message' => 'Se ha enviado un enlace para restablecer la contraseña.']);
                                                    } else  {

        echo json_encode(['status' => 'error', 'message' => 'El correo electrónico no está registrado.']);
    
        
    }
}catch(PDOException $e) {
    // En caso de error en la conexión o en la ejecución de la consulta
    echo json_encode(['status' => 'error', 'message' => 'Ocurrió un error en el servidor: ' . $e->getMessage()]);
}
  
}
?>

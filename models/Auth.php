<?php
require '../vendor/autoload.php';
// Asegúrate de incluir autoload de Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Auth {
    private $db; 
    private $userId;
    private $userRole;

    public function __construct($dbConnection) {
        $this->db = $dbConnection; // Conexión a la base de datos
    }

    public function login($usuario, $contrasena) {
        
        // Preparar la consulta
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE usu_usuario = :usuario LIMIT 1");
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        // Verificar si se encontró el usuario
        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar la contraseña (suponiendo que está encriptada)
            if (verificarCadena($contrasena,$user['usu_contrasena'] )) {
                // Guardar información del usuario
                $this->userId = $user['usu_codigo'];
                $this->userRole = $user['usu_role'];

                // Iniciar sesión y guardar información del usuario
                if (session_status() === PHP_SESSION_NONE) {
                    session_start(); // Iniciar la sesión solo si no hay una activa
                }
                $_SESSION['usu_codigo'] = $this->userId;
                
                $_SESSION['usu_role'] = $this->userRole;

                return true; // Inicio de sesión exitoso
            }
        }
        return false; // Credenciales inválidas
    }

/*
    public function forgotPassword($usu_email){
 
        $usu_email= $_POST['usu_email'];
        // Preparar la consulta
        $stmt = $this->db->prepare("SELECT usu_codigo FROM usuarios WHERE usu_correo = :usu_email LIMIT 1");
        
    if ( $stmt ) {
       // Preparar la consulta
    $stmt = $this->db->prepare("SELECT usu_codigo FROM usuarios WHERE usu_correo = :usu_email LIMIT 1");
    $stmt->bindParam(':usu_email', $usu_email, PDO::PARAM_STR);
    $stmt->execute();


        if ( $stmt->num_rows == 1 ) {
            // Genera un token único para el restablecimiento de contraseña
            $token = bin2hex( random_bytes( 50 ) );

            // Guarda el token en la base de datos
            $sql = 'UPDATE usuarios SET token = ? WHERE usu_correo = ?';
            $stmt = $this->db->prepare( $sql );
            $stmt->bind_param( 'ss', $token, $usu_email );
            $stmt->execute();

            // Envía un correo con PHPMailer
            $mail = new PHPMailer( true );
            
            try {
                echo 'Configurando PHPMailer...<br>';
                // Mensaje de depuración
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                // Cambia esto por tu servidor SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'aquimanuel8@gmail.com';
                // Tu correo
                $mail->Password = 'ocef tome giij xxwm ';
                // Tu contraseña
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                // o PHPMailer::ENCRYPTION_SMTPS
                $mail->Port = 587;
                // o 465

                // Destinatarios
                echo 'Configurando destinatarios...<br>';
                // Mensaje de depuración
                $mail->setFrom( 'aquimanuel8@gmail.com', 'BibliotecaMulti' );
                $mail->addAddress( $usu_email );

                // Contenido del correo
                /// Contenido del correo
                $reset_link = "http://localhost/proyectofinalmulti/views/restablecerContrasena.php?token=$token";

                $mail->isHTML( true );
                // Establece el correo como HTML
                $mail->Subject = 'Restablecimiento de contrasena';
                $mail->Body = "
    <html>
    <head>
        <style>
            body {
                margin: 0;
                padding: 0;
                background-image: url('https://example.com/path/to/your/background.jpg'); 
                background-size: cover;
                background-repeat: no-repeat;
                padding: 50px 0; 
            }
            .container {
                background-color: rgba(255, 255, 255, 0.9); 
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
                color: #ffffff;
                padding: 10px 15px;
                text-decoration: none;
                border-radius: 5px;
                display: inline-block;
                margin-top: 10px; 
            }
            a:hover {
                background-color: #0056b3;
            }
            
            @media only screen and (max-width: 600px) {
                .container {
                    width: 90%; 
                    padding: 15px; 
                }
                h2 {
                    font-size: 20px; 
                }
                p {
                    font-size: 14px; 
                }
                a {
                    padding: 8px 12px; 
                }
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>Restablecer su Contraseña</h2>
            <p>Haga clic en el siguiente enlace para restablecer su contraseña:</p>
            <p><a href='$reset_link'>Restablecer Contraseña</a></p>
            <p>Si no solicitó un restablecimiento de contraseña, ignore este mensaje.</p>
        </div>
    </body>
    </html>
";

                $mail->AltBody = "Haga clic en el siguiente enlace para restablecer su contraseña: $reset_link";
                // Texto alternativo para clientes de correo que no soportan HTML

                echo 'Enviando el correo...<br>';
                // Mensaje de depuración
                $mail->send();

                $_SESSION[ 'success' ] = 'Se ha enviado un enlace para restablecer la contraseña a su correo.';
                header( 'Location: ../../views/auth/contrasenaOlvidada.php' );
                exit();
            } catch ( Exception $e ) {
                echo 'Error al enviar el correo: ' . $mail->ErrorInfo . '<br>';
                // Mensaje de depuración
                $_SESSION[ 'error' ] = 'No se pudo enviar el correo. Mailer Error: ' . $mail->ErrorInfo;
                header( 'Location: ../../views/auth/contrasenaOlvidada.php' );
                exit();
            }
        } else {
            $_SESSION[ 'error' ] = 'No se encontró ningún usuario con ese correo electrónico.';
            header( 'Location: ../../views/auth/contrasenaOlvidada.php' );
            exit();
        }
    } else {
        $_SESSION[ 'error' ] = 'Error en la preparación de la consulta.';
        header( 'Location: .../../views/auth/contrasenaOlvidada.php' );
        exit();
    }
    
    $stmt->close();
}
*/

    public function logout() {
        session_start();
        session_destroy(); // Destruir la sesión
    }

    public function getUserId() {
        return $this->userId; // Devolver el ID del usuario
    }

    public function getUserRole() {
        return $this->userRole; // Devolver el rol del usuario
    }
}

?>

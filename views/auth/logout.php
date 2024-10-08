<?php
ob_start();
// Verificar si hay una sesión activa
if (isset($_SESSION['usu_codigo'])) {

    // Destruir la sesión
    session_unset(); // Elimina todas las variables de sesión
    session_destroy(); // Destruye la sesión

    // Redirigir a la página de inicio o a la página de login
    header("Location: ./index.php?page=auth/login");

    exit();
} else {
    // Si no hay sesión activa, redirigir a la página de login
    header("Location: ./index.php?page=auth/login");
    exit();
}
ob_end_flush();
?>

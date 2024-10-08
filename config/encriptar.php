<?php
// Función para encriptar cadenas
function encriptarCadena($string) {
    return password_hash($string, PASSWORD_DEFAULT); // Encriptar la cadena
}

// Función para verificar la contraseña
function verificarCadena($string, $hash) {  
    return password_verify($string, $hash); // Verificar la cadena encriptada
}
?>

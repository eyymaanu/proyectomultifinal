<?php
require_once('./config/database.php');

$pdo = Database::getConnection();

// Consultar los datos de los libros
$sql = "SELECT lib_codigo FROM libros"; 
$stmt = $pdo->query($sql);
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($libros) > 0): 
    foreach ($libros as $libro):
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Iniciar la sesión solo si no hay una activa
}
if(!isset($_SESSION['usu_codigo'])) {
    header("Location: views/auth/login.php?page=auth/login");
    exit();
}

// Ejemplo de manejo de rutas
if(isset($_SESSION['usu_codigo']) && $_SESSION['usu_role'] === 1) {
    $page = isset($_GET['page']) ? $_GET['page'] : 'admin/dashboard'; // Página predeterminada
}else if(isset($_SESSION['usu_codigo']) && $_SESSION['usu_role'] === 2) {
    $page = isset($_GET['page']) ? $_GET['page'] : 'consumidor/catalogo'; // Página predeterminada
}else{
    $page = isset($_GET['page']) ? $_GET['page'] : 'auth/login'; // Página predeterminada

}

switch ($page) {

    case 'auth/login':
            $content = 'views/auth/login.php';
        break;
        case 'consumidor/vistalibro':
            $content = 'views/consumidor/vistalibro.php';
            break;
        
        
    case 'admin/dashboard': 
        if(isset($_SESSION['usu_codigo']) && $_SESSION['usu_role'] === 2) {
            $content = "views/consumidor/catalogo.php";
        }else if(isset($_SESSION['usu_codigo']) && $_SESSION['usu_role'] === 1) {
            $content = 'views/admin/dashboard.php';
        }
        break;
    case 'consumidor/catalogo':
        $content = 'views/consumidor/catalogo.php';
        break;
    case 'consumidor/acercade':
        $content = 'views/consumidor/acercade.php';
        break;
    case 'admin/RegistrarUsuario':
        $content = 'views/admin/RegistrarUsuario.php';
        break;
    case 'auth/logout':
        $content = 'views/auth/logout.php';
        break;
    case 'admin/AgregarLibro':
        $content = 'views/admin/AgregarLibro.php';
            break;
    case 'admin/gestionarAutor':
                $content = 'views/admin/gestionarAutor.php';
            break;
    case 'admin/ReservarLibro':
        $content = 'views/admin/ReservarLibro.php';
            break;
    case 'admin/PrestarLibro':
        $content = 'views/admin/PrestarLibro.php';
            break;
    
    case 'admin/DevolverLibro':
        $content = 'views/admin/DevolverLibro.php';
            break;         
    default:
    if(isset($_SESSION['usu_codigo']) && $_SESSION['usu_role'] === 1) {
        $content = 'views/admin/dashboard.php'; 
}else if(isset($_SESSION['usu_codigo']) && $_SESSION['usu_role'] === 2) {
    $content = 'views/consumidor/catalogo.php';
}else{
    $content = 'views/auth/login.php';
}
break;

}
endforeach;
endif;
include('views/base.php'); // Incluir la plantilla base
  
?>

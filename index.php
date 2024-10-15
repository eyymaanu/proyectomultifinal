<?php
require_once('./config/database.php');

$pdo = Database::getConnection();

// Consultar los datos de los libros
$sql = "SELECT lib_codigo FROM libros"; 
$stmt = $pdo->query($sql);
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Iniciar la sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Iniciar la sesión solo si no hay una activa
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usu_codigo'])) {
    header("Location: views/auth/login.php?page=auth/login");
    exit();
}

// Manejo de rutas
$page = isset($_GET['page']) ? $_GET['page'] : (isset($_SESSION['usu_role']) && $_SESSION['usu_role'] === 1 ? 'admin/dashboard' : 'consumidor/catalogo'); // Página predeterminada

// Inicializar content
$content = ''; // Inicialización antes de usar

switch ($page) {
    case 'auth/login':
        $content = 'views/auth/login.php';
        break;
    case 'consumidor/vistalibro':
        $content = 'views/consumidor/vistalibro.php';
        break;
    case 'admin/dashboard': 
        $content = (isset($_SESSION['usu_role']) && $_SESSION['usu_role'] === 1) ? 'views/admin/dashboard.php' : 'views/consumidor/catalogo.php';
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
        $content = (isset($_SESSION['usu_role']) && $_SESSION['usu_role'] === 1) ? 'views/admin/dashboard.php' : 'views/consumidor/catalogo.php';
        break;
}

include('views/base.php'); // Incluir la plantilla base

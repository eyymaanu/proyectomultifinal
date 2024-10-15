<?php

ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Iniciar la sesión solo si no hay una activa
}
?>
    <?php if (isset($_SESSION['usu_codigo'])): ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/estilos.min.css"> <!-- Usar versión minificada -->
    <title>Biblioteca</title>
    <style>
        /* Estilos personalizados para el navbar */
        .navbar {
            transition: background-color 0.3s ease; /* Transición suave para el fondo */

            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.7); 
        }

        .navbar-nav .nav-link {
            color: #fff;
        }

        .navbar-nav .nav-link:hover {
            color: #fff;
        }
        
        body {
    font-family: 'Arial', sans-serif;
}

.navbar {
    transition: all 0.8s ease;
    color: #fff;
}

.navbar-brand {
    font-weight: bold;
    color: #fff;
    transition: all 0.8s ease;
}

.navbar-brand:hover {
    color: blue;
    transition: all 0.8s ease;
}




.nav-link {
    color: #fff;
    position: relative;
    transition: color 0.8s ease;
    padding: 0.5rem 0;
    margin-right: 1rem;
}

.nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: 0;
    left: 0;
    background-color: #fff;
    transition: width 0.3s ease;
}

.nav-link:hover {
    color: #fff;
}

.nav-link:hover::after {
    width: 100%;
}

.nav-link:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

@media (max-width: 991px) {
    .navbar-nav {
        flex-direction: row;
    }

    .nav-link {
        margin-left: 0;
    }
}
button{
    color: #fff;
    border: none;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
button:hover{
    background-color: rgba(0,0,0,0.1);
    border:none;
}
.navbar-brand{
    color:white;
    
}




    </style>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
       
</head>

<body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg  sticky-top bg-transparent">
            <div class="container">

                <a class="navbar-brand " href="index.php?page=consumidor/catalogo">Biblioteca</a>
                <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon "></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                
                <!-- Solo muestra estos enlaces si el usuario tiene rol de administrador (role = 1) -->
                <?php if (isset($_SESSION['usu_role']) && $_SESSION['usu_role'] === 1): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=admin/dashboard">Admin</a>
                    </li>
                    <?php endif; ?>
                    
                <!-- Mostrar el acerca de nosotros accecible para todos -->
                    <li class="nav-item">
                            <a class="nav-link" href="index.php?page=consumidor/acercade">Acerca de</a>
                        </li>
                    
                    <!-- Catálogo accesible para todos los usuarios -->
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=consumidor/catalogo">Catálogo</a>
                    </li>
                    
                    <!-- Enlace de cierre de sesión si el usuario está logueado -->
                    <?php if (isset($_SESSION['usu_codigo'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=auth/logout">Cerrar Sesión</a>
                        </li>
                        <!-- Enlace de inicio de sesión si no está logueado -->
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?page=auth/login">Iniciar Sesión</a>
                            </li>
                            <?php endif; ?>
            </ul>
                    </div>
                </div>
                </nav>
                
                <!-- Contenedor principal -->
                <div class="container mt-2 pt-3"> <!-- Ajusta el margen superior para que el contenido no quede oculto por el navbar -->
                    <?php endif; ?>
                    <?php include($content); ?>
                </div>
                
                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                
                <!-- Script para cambiar la opacidad del navbar al hacer scroll -->
                <script>
                    $(window).scroll(function() {
                        if ($(this).scrollTop() > 50) {
                $('.navbar').addClass('scrolled');
            } else {
                $('.navbar').removeClass('scrolled');
            }
        });
        </script>
</body>

</html>
<?php ob_end_flush(); ?>
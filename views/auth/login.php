<?php $content = 'base.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Biblioteca</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Estilo del contenedor del login */
        .login-container {
            max-width: 400px; /* Ancho máximo del contenedor */
            padding: 30px;
            border-radius: 50px;
            background: linear-gradient(315deg, #f0f0f0, #cacaca);
            box-shadow: -19px -19px 38px #000, 19px 19px 38px #000; /* Sombra negra */
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #007bff; /* Color del título */
        }

        /* Estilos para los inputs */
        .form-control {
            border: none; /* Sin borde */
            border-bottom: 2px solid #007bff; /* Borde inferior */
            border-radius: 0; /* Eliminar bordes redondeados */
            box-shadow: none; /* Sin sombra */
            padding: 10px;
            background-color: #f7f9fc; 

        }

        .form-control:focus {
            outline: none; /* Sin outline */
            box-shadow: none; /* Sin sombra al hacer focus */
            border-bottom: 2px solid #0056b3; /* Color al hacer focus */
            background-color: #f7f9fc; 
        }

        /* Estilo del botón de login */
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 20px; /* Bordes redondeados */
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Centrado del enlace de registro */
        .form-group a {
            text-align: center;
            display: block;
            margin-top: 15px;
        }
       

        /* From Uiverse.io by mrhyddenn */ 
button {
  position: relative;
  padding: 10px 20px;
  border-radius: 7px;
  border: 1px solid rgb(61, 106, 255);
  font-size: 14px;
  text-transform: uppercase;
  font-weight: 600;
  letter-spacing: 2px;
  background: transparent;
  color: #fff;
  overflow: hidden;
  box-shadow: 0 0 0 0 transparent;
  -webkit-transition: all 0.2s ease-in;
  -moz-transition: all 0.2s ease-in;
  transition: all 0.2s ease-in;
}

button:hover {
  background: rgb(61, 106, 255);
  box-shadow: 0 0 30px 5px rgba(0, 142, 236, 0.815);
  -webkit-transition: all 0.2s ease-out;
  -moz-transition: all 0.2s ease-out;
  transition: all 0.2s ease-out;
}

button:hover::before {
  -webkit-animation: sh02 0.5s 0s linear;
  -moz-animation: sh02 0.5s 0s linear;
  animation: sh02 0.5s 0s linear;
}

button::before {
  content: '';
  display: block;
  width: 0px;
  height: 86%;
  position: absolute;
  top: 7%;
  left: 0%;
  opacity: 0;
  background: #fff;
  box-shadow: 0 0 50px 30px #fff;
  -webkit-transform: skewX(-20deg);
  -moz-transform: skewX(-20deg);
  -ms-transform: skewX(-20deg);
  -o-transform: skewX(-20deg);
  transform: skewX(-20deg);
}


@keyframes sh02 {
    from {
      opacity: 0;
      left: 0%;
    }
  
    50% {
      opacity: 1;
    }
  
    to {
      opacity: 0;
      left: 100%;
    }
  }
  
  button:active {
    box-shadow: 0 0 0 0 transparent;
    -webkit-transition: box-shadow 0.2s ease-in;
    -moz-transition: box-shadow 0.2s ease-in;
    transition: box-shadow 0.2s ease-in;
  }
  /* From Uiverse.io by Praashoo7 */ 
  .input {
    border: none;
    outline: none;
    border-radius: 15px;
    padding: 1em;
    background-color: #ccc;
    box-shadow: inset 2px 5px 10px rgba(0,0,0,0.3);
    transition: 300ms ease-in-out;
  }
  
  .input:focus {
    background-color: white;
    transform: scale(1.05);
    box-shadow: 13px 13px 100px #969696,
               -13px -13px 100px #ffffff;
  }
  .fondo {
    background-color: hsla(201, 0%, 0%, 1);
    background-image: radial-gradient(circle at 53% 47%, hsla(172.0588235294118, 100%, 15%, 0.46) 12.234752994669636%, transparent 52.264096832990425%), radial-gradient(circle at 0% 50%, hsla(248.51427637118405, 100%, 13%, 1) 19.036690230222092%, transparent 50%), radial-gradient(circle at 4% 10%, hsla(255.44117647058818, 0%, 0%, 1) 11.730126878761642%, transparent 50%), radial-gradient(circle at 80% 50%, hsla(255.44117647058818, 0%, 0%, 1) 0%, transparent 50%), radial-gradient(circle at 80% 0%, hsla(242.2058823529412, 100%, 28%, 1) 0%, transparent 50%), radial-gradient(circle at 0% 100%, hsla(0, 0%, 29%, 0) 0%, transparent 50%), radial-gradient(circle at 80% 100%, hsla(0, 0%, 10%, 0) 0%, transparent 50%), radial-gradient(circle at 0% 0%, hsla(184.00000000000026, 10%, 14%, 0) 0%, transparent 50%);
    background-blend-mode: normal, normal, normal, normal, normal, normal, normal, normal;
}
.padre{
display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}


    </style>
</head>
<body class="fondo">
<div class="padre">

    <div class="login-container">
        
        
        <h1 style="text-align: center;">Iniciar Sesión</h1>
        <p style="text-align: center;">Para Iniciar Sesión debes de acercarte a la Biblioteca para Registrarte como Usuario</p>
        
        <form action="../../controllers/loginControlador.php" method="POST"> <!-- Asegúrate de la ruta correcta -->
            <div class="form-group" style="margin-top: 20px;">
                
                <input type="text" class="form-control input" id="usuario" name="usuario" required placeholder="Username">
            </div>
            
            
            <div class="form-group">
                
                <input type="password" class="form-control input" id="contrasena" name="contrasena" required placeholder="Contraseña">
            </div>
            <div class="form-group">
                <a href="../auth/contrasenaOlvidada.php">¿Olvidaste tu contraseña?</a>
            </div>
            
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
        
        
    </div>
</div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>
</html>

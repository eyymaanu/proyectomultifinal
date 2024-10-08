<?php $content = 'base.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrador</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos para el dashboard */
        .dashboard-container {
            margin-top: 50px;
        }

        .dashboard-header {
            text-align: center;
            margin-bottom: 40px;
        }

        /* Estilos para los botones de acción */
        .dashboard-btn {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        /* Sombra y espaciado en las tarjetas */
        .card {
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        a:hover{
            text-decoration: none;
        }
        body {
    background-color: #f8f9fa;
}

.container {
    max-width: 1200px;
}

.row {
    --bs-gutter-x: 2rem;
}

.card {
    transition: transform 0.3s, box-shadow 0.3s;
    border-radius: 15px;
    overflow: hidden;
    border: none;
    background-color: #ffffff;
    height: 100%;
    display: flex;
    flex-direction: column;
    cursor: pointer;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.card-img-wrapper {
    overflow: hidden;
    padding-top: 66.67%;
    position: relative;
}

.card-img-top {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-body {
    background-color: #f1f8ff;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    padding: 1.5rem;
}

.card-title {
    color: #0056b3;
    font-size: 1.25rem;
    margin-bottom: 0.75rem;
}

.card-text {
    color: #495057;
    flex-grow: 1;
}

.col {
    margin-bottom: 2rem;
}

@media (min-width: 768px) {
    .row-cols-md-3 > * {
        flex: 0 0 auto;
        width: 33.333333%;
    }
}

@media (max-width: 767.98px) {
    .row-cols-1 > * {
        flex: 0 0 auto;
        width: 100%;
    }
}

@media (max-width: 767.98px) {
    .card-body {
        padding: 2rem !important;
    }
}

.form-control:focus,
.form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-control.is-invalid,
.form-select.is-invalid {
    border-color: #dc3545;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.form-control.is-invalid:focus,
.form-select.is-invalid:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
}
body {
    background-color: hsla(224, 70%, 17%, 1);
    background-image: radial-gradient(circle at 91% 91%, hsla(276, 72%, 4%, 0.46) 10%, transparent 57%), radial-gradient(circle at 74% 100%, hsla(198.52941176470594, 81%, 13%, 1) 4.686035613870666%, transparent 53.22497469929746%), radial-gradient(circle at 84% -28%, hsla(274, 90%, 2%, 1) 4%, transparent 31.015962152025246%), radial-gradient(circle at 77% 7%, hsla(269, 82%, 4%, 1) 6.207095747700115%, transparent 73%), radial-gradient(circle at 12% 18%, hsla(269, 82%, 4%, 1) 19.241823834577453%, transparent 73%), radial-gradient(circle at 75% 55%, hsla(222.00000000000006, 98%, 48%, 1) 13%, transparent 84%), radial-gradient(circle at 15% 83%, hsla(166.00000000000006, 96%, 20%, 1) 17%, transparent 60%);
    background-blend-mode: normal, normal, normal, normal, normal, normal, normal;
}

    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col mb-4">
            <a href="index.php?page=admin/RegistrarUsuario" >
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1549732565-d673b928da7f?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top" alt="Tranquil cityscape">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Registrar Usuario</h5>
                        <p class="card-text flex-grow-1">Registra los Usuarios Para que accedan al catalogo de libros.</p>
                    </div>
                </div>
            </a>


            </div>

            <div class="col mb-4">
                <a href="index.php?page=admin/AgregarLibro">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top" alt="Misty mountains">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Registrar Libros</h5>
                        <p class="card-text flex-grow-1">Agregar Libros de la biblioteca en el sistema web.</p>
                    </div>
                </div>
                </a>
            </div>

            <div class="col mb-4">
                <a href="index.php?page=admin/gestionarAutor">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-img-wrapper">
                        <img src="https://plus.unsplash.com/premium_photo-1661383948918-f17cc65b0e21?q=80&w=2067&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top" alt="Peaceful beach">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Registrar Autores</h5>
                        <p class="card-text flex-grow-1">Registrar Autores de los libros que se registrarán en el sistema.</p>
                    </div>
                </div>
                </a>
            </div>

            <div class="col mb-4">
            <a href="index.php?page=admin/PrestarLibro">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-img-wrapper">
                        <img src="https://3.bp.blogspot.com/-pSFsqlGZFjs/WIABV-ut6uI/AAAAAAAAAhk/26ga7efbSI4gjsP9d1v3FDAOpBnhp0WgQCLcB/s400/prestamo.gif" class="card-img-top" alt="Zen garden">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Revisar Prestamos</h5>
                        <p class="card-text flex-grow-1">Revisar los libros prestados</p>
                    </div>
                </div>
            </a>
            </div>
            
            <div class="col mb-4">
            <a href="index.php?page=admin/ReservarLibro">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-img-wrapper">
                        <img src="https://www.comunidadbaratz.com/wp-content/uploads/El-prestamo-de-libros-ha-sido-es-y-seguira-siendo-el-servicio-estrella-de-las-bibliotecas.jpg" class="card-img-top" alt="Calm lake">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Libros Reservados</h5>
                        <p class="card-text flex-grow-1">Ver los libros reservados que se encuentran registrados en el sistema .</p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col mb-4">
                <a href="index.php?page=admin/DevolverLibro">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-img-wrapper">
                        <img src="https://escoladeartelugo.com//wp-content/uploads/2020/06/devlib01.png" class="card-img-top" alt="Starry sky">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Libros Devueltos</h5>
                        <p class="card-text flex-grow-1">Ver los libros devueltos en el sistema</p>
                    </div>
                </div>
            </div>
            </a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</body>
</html>

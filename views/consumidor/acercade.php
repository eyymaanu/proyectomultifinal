<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acerca de Nosotros</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos */
        .about-section {
            padding: 60px 0;
            background-color: #f8f9fa;
        }

        .about-section h2 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 40px;
            text-align: center;
            color: #343a40;
        }

        .team-member {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 30px;
            transition: transform 0.3s;
        }

        .team-member:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .team-member img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .team-member h5 {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
        }

        .team-member p {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .team-member img {
                width: 80px;
                height: 80px;
            }

            .team-member h5 {
                font-size: 18px;
            }
        }
        .fondo {
            background-color: hsla(201, 0%, 0%, 1);
            background-image: radial-gradient(circle at 53% 47%, hsla(172.0588235294118, 100%, 15%, 0.46) 12.234752994669636%, transparent 52.264096832990425%), radial-gradient(circle at 0% 50%, hsla(248.51427637118405, 100%, 13%, 1) 19.036690230222092%, transparent 50%), radial-gradient(circle at 4% 10%, hsla(255.44117647058818, 0%, 0%, 1) 11.730126878761642%, transparent 50%), radial-gradient(circle at 80% 50%, hsla(255.44117647058818, 0%, 0%, 1) 0%, transparent 50%), radial-gradient(circle at 80% 0%, hsla(242.2058823529412, 100%, 28%, 1) 0%, transparent 50%), radial-gradient(circle at 0% 100%, hsla(0, 0%, 29%, 0) 0%, transparent 50%), radial-gradient(circle at 80% 100%, hsla(0, 0%, 10%, 0) 0%, transparent 50%), radial-gradient(circle at 0% 0%, hsla(184.00000000000026, 10%, 14%, 0) 0%, transparent 50%);
            background-blend-mode: normal, normal, normal, normal, normal, normal, normal, normal;
        }

    </style>
</head>

<body class= fondo>

<div class="about-section">
    <h2>Acerca de Nosotros</h2>
    <div class="container">
        <div class="row">

            <!-- Alan  -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="team-member">
                    <img src="./img/alan.jpeg" alt="Foto de estudiante 1">
                    <h5>Alan Bogado</h5>
                    <p>Tercero Informatica</p>
                    <p></p>
                </div>
            </div>

            <!-- Manu -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="team-member">
                    <img src="./img/manu.jpeg" alt="Foto de estudiante 2">
                    <h5>Manuel Aquino</h5>
                    <p>Tercero Informatica</p>
                    <p>Un apasionado por la programación, le interesa el mundo de la informática y piensa seguir sus estudios en la carrera de Ing. Informática.</p>
                </div>
            </div>

            <!-- Maira -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="team-member">
                    <img src="./img/maira.jpeg" alt="Foto de estudiante 3">
                    <h5>Maira Castillo</h5>
                    <p>Tercero Informatica</p>
                    <p></p>
                </div>
            </div>

            <!-- Raquel -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="team-member">
                    <img src="https://via.placeholder.com/100" alt="Foto de estudiante 4">
                    <h5>Raquel Alegre</h5>
                    <p>Tercero Informatica</p>
                    <p></p>
                </div>
            </div>

            <!-- Janice -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="team-member">
                    <img src="./img/janice.jpeg" alt="Foto de estudiante 5">
                    <h5>Janice Villalba</h5>
                    <p>Tercero Informatica</p>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

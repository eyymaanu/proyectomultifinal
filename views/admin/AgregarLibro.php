<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Libro - Administrador</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    .table-container {
        margin-top: 40px;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-container {
        margin-top: 40px;
        padding: 30px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 1;
        background-color: rgba(237, 231, 225);
        /* Para asegurarse de que esté por encima del fondo */
    }

    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* From Uiverse.io by Yaya12085 */
    .custum-file-upload {
        height: 58px;
        /* Ajusta la altura para que coincida con los inputs de texto */
        width: 100%;
        /* Ajusta el ancho para que coincida con los inputs de texto */
        display: flex;
        flex-direction: row;
        /* Cambia a fila para que la imagen y el texto estén en línea */
        align-items: center;
        gap: 10px;
        /* Ajusta el espacio entre la imagen y el texto */
        cursor: pointer;
        justify-content: flex-start;
        /* Alinea el contenido al inicio */
        border: 2px dashed #cacaca;
        background-color: rgba(255, 255, 255, 1);
        padding: 0.5rem;
        /* Ajusta el padding para que coincida con los inputs de texto */
        border-radius: 5px;
        /* Ajusta el radio de borde para que coincida con los inputs de texto */
        box-shadow: 0px 48px 35px -48px rgba(0, 0, 0, 0.1);
    }

    .custum-file-upload .icon {
        display: flex;
        align-items: center;
    }

    .custum-file-upload .icon svg {
        height: 30px;
        /* Ajusta la altura de la imagen */
        fill: rgba(75, 85, 99, 1);
    }



    .custum-file-upload .text span {
        font-weight: 400;
        color: rgba(75, 85, 99, 1);
        display: flex;
        align-items: center;
        justify-content: center;
    }


    .custum-file-upload input {
        display: none;
    }

    /* From Uiverse.io by bedirhan-arslan */
    .formField {
        margin: 10px;
        position: relative;
    }

    .formField input {
        padding: 10px 15px;
        outline: none;
        border: none;
        border-radius: 5px;
        background-color: #f1f1f1;
        color: #333;
        font-size: 16px;
        font-weight: 550;
        transition: 0.3s ease-in-out;
        box-shadow: 0 0 0 5px transparent;
    }

    .formField input:hover,
    .formField input:focus {
        box-shadow: 0 0 0 2px #333;
    }

    .formField span {
        position: absolute;
        left: 0;
        top: 0;
        padding: 8px 15px;
        color: #333;
        font-size: 16px;
        font-weight: 600;
        transition: 0.3s ease-in-out;
        pointer-events: none;
    }

    .formField input:focus+span,
    .formField input:valid+span {
        transform: translateY(-32px) translateX(-5px) scale(0.95);
        transition: 0.3s ease-in-out;
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

    body {
        background: url('https://i.blogs.es/9d0ebf/biblioteca/1366_2000.jpg') no-repeat center center fixed;
        background-size: cover;
        background-color: #000;
        min-height: 100vh;
        position: relative;
    }

    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.7);
        /* Opacidad oscura */
        z-index: 0;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container shadow-lg">
            <h2 class="text-center mb-4">Agregar Nuevo Libro</h2>
            <!-- Formulario para agregar libro con carga de imagen -->
            <form action="./controllers/agregarLibroControlador.php" class="formField" method="POST"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control " id="titulo" name="lib_titulo" required
                            placeholder="Ingrese el título del libro">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        
                            <select class="form-control" id="categoria" name="lib_categoria" required>
                            <option value="" disabled selected>Seleccione una Categoria</option>
                            <option value="Novela">Novela</option>
                            <option value="Cuento">Cuento</option>
                            <option value="Administracion">Administracion</option>
                            <option value="Contabilidad">Contabilidad</option>
                            <option value="Matematica">Matematica</option>
                            <option value="Castellano">Castellano</option>
                            <option value="Progamacion">Programacion</option>
                            <option value="Historia">Historia</option>
                            

                            </select>

                        <!--Crear select para categoria de libros-->
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="img" class="form-label">Imagen del Libro</label>
                        <label class="custum-file-upload" for="img">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24">
                                    <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                    <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill=""
                                            d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z"
                                            clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </g>
                                </svg>
                            </div>

                            Clic para subir la imagen del libro

                            <input type="file" class="form_control" id="img" name="lib_img" accept="image/*" required>
                        </label>

                    </div>


                    <div class="col-md-6 mb-3">
                        <label for="autor" class="form-label">Autor</label>
                        <select class="form-control" id="autor" name="lib_autor" required>
                            <option value="" disabled selected>Seleccione un autor</option>
                            <?php
                            // Código PHP para generar las opciones de autores usando PDO
                            require_once './config/database.php';
                            $conn = Database::getConnection();
                            $sql = "SELECT Autores_id, Autor_nombre FROM autores";
                            $stmt = $conn->query($sql);
                            $autores = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            if (!empty($autores)) {
                                foreach ($autores as $autor) {
                                    echo '<option value="' . htmlspecialchars($autor['Autores_id']) . '">' . htmlspecialchars($autor['Autor_nombre']) . '</option>';
                                }
                            } else {
                                echo '<option value="">No hay autores disponibles</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cantidad" class="form-label">Cantidad Real</label>
                        <input type="number" class="form-control " id="cantidad" name="lib_cantidad_real" required
                            placeholder="Ingrese la cantidad real">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label">Stock Actual</label>
                        <input type="number" class="form-control " id="stock" name="lib_stock_real" required
                            placeholder="Ingrese el stock actual">
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn btn-primary">Agregar Libro</button>
                </div>
            </form>


        </div>
    </div>

    <div class="table-container shadow-lg mt-5" style="background-color: rgba(237,231,225);position: relative;
        z-index: 1;">
        <h2>Lista de Libros</h2>
        <table class="table table-stripe">
            <thead class="table-dark">
                <tr>

                    <th>Ttulo</th>
                    <th>Autor</th>
                    <th>Categoria</th>
                    <th>Imagen</th>
                    <th>Cantidad real</th>
                    <th>Stock Actual</th>

                    <th class="text-end">Acciones</th>

                </tr>
            </thead>
            <tbody>
                                           <?php
                            $sql = "SELECT lib_codigo, lib_titulo, lib_autor_codigo, lib_categoria, lib_img, lib_cantidad_real, stock_actual FROM libros";
                            $stmt = $conn->query($sql);
                            $Libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            if (!empty($Libros)) {
                                foreach ($Libros as $Libro) {
                                    // Fila normal con el autor
                                    echo '<tr id="row-' . $Libro['lib_codigo'] . '">';
                                    echo '<td>' . htmlspecialchars($Libro['lib_titulo']) . '</td>';
                                    // Obtener el nombre del autor
                                    $autorSql = "SELECT Autor_nombre FROM autores WHERE Autores_id = :autor_id";
                                    $autorStmt = $conn->prepare($autorSql);
                                    $autorStmt->bindParam(':autor_id', $Libro['lib_autor_codigo']);
                                    $autorStmt->execute();
                                    $autor = $autorStmt->fetch(PDO::FETCH_ASSOC);
                                    echo '<td>' . htmlspecialchars($autor['Autor_nombre']) . '</td>';
                                    echo '<td>' . htmlspecialchars($Libro['lib_categoria']) . '</td>';
                            
                                    echo '<td>
                                    <img src="data:image/jpeg;base64,' . base64_encode($Libro['lib_img']) . '" alt="Imagen del libro" style="width: 50px; height: auto;">
                                    </td>';
                            
                                    echo '<td>' . htmlspecialchars($Libro['lib_cantidad_real']) . '</td>';
                                    echo '<td>' . htmlspecialchars($Libro['stock_actual']) . '</td>';
                                    echo '<td class="text-end">
                                            <button class="btn btn-warning btn-sm" onclick="editRow(' . $Libro['lib_codigo'] . ')">Editar</button>
                                            <form method="POST" action="./controllers/deletelibro.php" style="display:inline;"> 
                                                <input type="hidden" name="lib_codigo" value="' . $Libro['lib_codigo'] . '">
                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>
                                          </td>';
                                    echo '</tr>';
                            
                                    // Fila de edición oculta
                                    echo '<tr id="edit-row-' . $Libro['lib_codigo'] . '" style="display:none;">';
                                    echo '<form method="POST" action="./controllers/editarlibro.php" enctype="multipart/form-data">';  // Añadir enctype para soportar archivos
                            
                                    echo '<input type="hidden" name="lib_codigo" value="' . $Libro['lib_codigo'] . '">';
                                    // Agregar un campo oculto para almacenar la imagen actual
                                    echo '<input type="hidden" name="lib_img_actual" value="' . htmlspecialchars($Libro['lib_img']) . '">'; // Aquí se guarda el valor original
                            
                                    // Mostrar la imagen existente
                                    echo '<td><input type="text" name="lib_titulo" class="form-control" value="' . htmlspecialchars($Libro['lib_titulo']) . '"></td>';
                            
                                    echo '<td><select name="lib_autor_codigo" class="form-control">';
                                    $autorSql = "SELECT Autores_id, Autor_nombre FROM autores";
                                    $autorStmt = $conn->query($autorSql);
                                    $autores = $autorStmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($autores as $autor) {
                                        $selected = ($autor['Autores_id'] == $Libro['lib_autor_codigo']) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($autor['Autores_id']) . '" ' . $selected . '>' . htmlspecialchars($autor['Autor_nombre']) . '</option>';
                                    }
                                    echo '</select></td>';
                            
                                    echo '<td><input type="text" name="lib_categoria" class="form-control" value="' . htmlspecialchars($Libro['lib_categoria']) . '"></td>';
                            
                                    echo '<td>
                                        <input type="file" id="img" name="lib_img" accept="image/*">
                                        <img src="data:image/jpeg;base64,' . base64_encode($Libro['lib_img']) . '" alt="Imagen del libro" style="width: 50px; height: auto;">
                                      </td>';
                            
                                    echo '<td><input type="text" name="lib_cantidad_real" class="form-control" value="' . htmlspecialchars($Libro['lib_cantidad_real']) . '"></td>';
                                    echo '<td><input type="text" name="lib_stock_real" class="form-control" value="' . htmlspecialchars($Libro['stock_actual']) . '"></td>';
                            
                                    echo '<td class="text-end">
                                            <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                                            <button type="button" class="btn btn-secondary btn-sm" onclick="cancelEdit(' . $Libro['lib_codigo'] . ')">Cancelar</button>
                                          </td>';
                                    echo '</form>';
                            
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center">No hay libros registrados.</td></tr>';
                            }
 ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function editRow(id) {
        document.getElementById(`row-${id}`).style.display = 'none';
        document.getElementById(`edit-row-${id}`).style.display = '';
    }

    function cancelEdit(id) {
        document.getElementById(`row-${id}`).style.display = '';
        document.getElementById(`edit-row-${id}`).style.display = 'none';
    }
    </script>
</body>

</html>
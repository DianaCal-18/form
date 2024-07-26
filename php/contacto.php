<?php
include_once 'consultas.php';
include_once 'conexion.php';

$conexion_objeto = new Conexion();
$conexion = $conexion_objeto->ConexionBD();

if (!$conexion) {
    die("Error al conectar a la base de datos");
}

// Manejar la acción de eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($id) {
        $consulta = new Consultas($conexion);
        $consulta->eliminarContacto($id);
        // Redirigir para evitar reenvíos de formulario
        header("Location: contacto.php");
        exit();
    }
}

// Manejar el formulario de contacto
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['eliminar'])) {
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);
    $asunto = filter_input(INPUT_POST, 'asunto', FILTER_SANITIZE_STRING);
    $comentario = filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_STRING);

    if ($nombre && $correo && $asunto && $comentario) {
        $consulta = new Consultas($conexion);
        $consulta->insertarContacto($nombre, $correo, $asunto, $comentario);
    }
}

$consulta = new Consultas($conexion);
$contactos = $consulta->obtenerMensajes();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Proyecto Final</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <link href="/css/styles.css" rel="stylesheet" />
</head>
<body id="page-top">
    <!--MENU-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#page-top">Diana Calderon</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link" href="/index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="ej.php">Libros</a></li>
                    <li class="nav-item"><a class="nav-link" href="autores.php">Autores</a></li>
                    <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="page-section bg-dark text-white">
        <div class="container px-4 px-lg-5 text-center">
            <h2 class="mb-4">Contacto</h2>
        </div>
    </section>
    <!-- Contacto-->
    <section class="page-section" id="contact">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 col-xl-6 text-center">
                    <h2 class="mt-0">¡Pongámonos en contacto!</h2>
                    <hr class="divider" />
                    <p class="text-muted mb-5">¿Listo para descubrir tu próxima gran lectura con nosotros? ¡Envíanos un mensaje y te responderemos lo antes posible!</p>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                <div class="col-lg-6">
                    <form id="contactForm" method="POST" action="contacto.php">
                        <!-- Nombre-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Enter your name..." data-sb-validations="required" />
                            <label for="nombre">Nombre</label>
                            <div class="invalid-feedback" data-sb-feedback="name:required">El nombre es requerido.</div>
                        </div>
                        <!-- Email-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="correo" name="correo" type="email" placeholder="name@example.com" data-sb-validations="required,email" />
                            <label for="correo">Correo Electronico</label>
                            <div class="invalid-feedback" data-sb-feedback="email:required">El correo electronico es requerido.</div>
                            <div class="invalid-feedback" data-sb-feedback="email:email">El Correo electronico no es valido.</div>
                        </div>
                        <!-- Asunto-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="asunto" name="asunto" type="text" placeholder="escriba el asunto.." data-sb-validations="required" />
                            <label for="asunto">Asunto</label>
                            <div class="invalid-feedback" data-sb-feedback="asunto:required">El asunto es requerido.</div>
                        </div>
                        <!-- Mensaje-->
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="comentario" name="comentario" type="text" placeholder="Enter your message here..." style="height: 10rem" data-sb-validations="required"></textarea>
                            <label for="comentario">Mensaje</label>
                            <div class="invalid-feedback" data-sb-feedback="message:required">Mensaje es requerido.</div>
                        </div>
                        <div class="d-none" id="submitSuccessMessage">
                            <div class="text-center mb-3">
                                <div class="fw-bolder">Formulario enviado de manera satisfactoria!</div>
                                <br />
                            </div>
                        </div>
                        <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                        <!-- Enviar btn-->
                        <div class="d-grid"><button class="btn btn-primary btn-xl" id="submitButton" type="submit">Enviar</button></div>
                    </form>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 col-xl-6 text-center">
                    <h2 class="mt-5">Registros de Contacto</h2>
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Asunto</th>
                                <th>Comentario</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($contactos as $contacto) : ?>
          <tr>
            <td><?= htmlspecialchars($contacto['id']) ?></td>
            <td><?= htmlspecialchars($contacto['fecha']) ?></td>
            <td><?= htmlspecialchars($contacto['nombre']) ?></td>
            <td><?= htmlspecialchars($contacto['correo']) ?></td>
            <td><?= htmlspecialchars($contacto['asunto']) ?></td>
            <td><?= htmlspecialchars($contacto['comentario']) ?></td>
            <td>
               <!-- Btn  actualizar -->
               <form action="actualizar.php" method="GET" style="display:inline;">
                <input type="hidden" name="id" value="<?= htmlspecialchars($contacto['id']) ?>">
                 <button type="submit" class="btn btn-warning btn-sm" style="margin-right: 10px;">Actualizar</button>
                </form>
                <!-- Btn eliminar -->
            <form action="contacto.php" method="POST" style="display:inline;">
             <input type="hidden" name="id" value="<?= htmlspecialchars($contacto['id']) ?>">
             <button type="submit" name="eliminar" class="btn btn-danger btn-sm">Eliminar</button>
            </form>
            </td>
        </tr>
            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- Pie-->
    <footer class="bg-light py-5">
        <div class="container px-4 px-lg-5">
            <div class="small text-center text-muted">Copyright &copy; 2024 - Libreria DC</div>
        </div>
    </footer>
    <!-- JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <script src="js/scripts.js"></

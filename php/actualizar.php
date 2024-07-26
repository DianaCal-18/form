<?php
include_once 'consultas.php';
include_once 'conexion.php';

$conexion_objeto = new Conexion();
$conexion = $conexion_objeto->ConexionBD();

if (!$conexion) {
    die("Error al conectar a la base de datos");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);
    $asunto = filter_input(INPUT_POST, 'asunto', FILTER_SANITIZE_STRING);
    $comentario = filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_STRING);

    if ($id && $nombre && $correo && $asunto && $comentario) {
        $consulta = new Consultas($conexion);
        if ($consulta->actualizarContacto($id, $nombre, $correo, $asunto, $comentario)) {
            header("Location: contacto.php");
            exit();
        } else {
            echo "Error al actualizar el contacto.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
} else {
    $id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';

    if ($id) {
        $consulta = new Consultas($conexion);
        $contacto = $consulta->obtenerContactoPorId($id);

        if ($contacto) {
            $nombre = htmlspecialchars($contacto['nombre']);
            $correo = htmlspecialchars($contacto['correo']);
            $asunto = htmlspecialchars($contacto['asunto']);
            $comentario = htmlspecialchars($contacto['comentario']);
        } else {
            die("No se encontró el contacto.");
        }
    } else {
        die("ID de contacto no proporcionado.");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <section class="page-section" id="contact">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 col-xl-6 text-center">
                    <hr class="divider" />
                    <p class="text-muted mb-5">Actualizar comentario</p>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                <div class="col-lg-6">
                    <form id="contactForm" method="POST" action="actualizar.php">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <!-- Nombre-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="nombre" name="nombre" type="text" value="<?= $nombre ?>" data-sb-validations="required" />
                            <label for="nombre">Nombre</label>
                            <div class="invalid-feedback" data-sb-feedback="nombre:required">El nombre es requerido.</div>
                        </div>
                        <!-- Email-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="correo" name="correo" type="email" value="<?= $correo ?>" data-sb-validations="required,email" />
                            <label for="correo">Correo Electrónico</label>
                            <div class="invalid-feedback" data-sb-feedback="correo:required">El correo electrónico es requerido.</div>
                            <div class="invalid-feedback" data-sb-feedback="correo:email">El correo electrónico no es válido.</div>
                        </div>
                        <!-- Asunto-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="asunto" name="asunto" type="text" value="<?= $asunto ?>" data-sb-validations="required" />
                            <label for="asunto">Asunto</label>
                            <div class="invalid-feedback" data-sb-feedback="asunto:required">El asunto es requerido.</div>
                        </div>
                        <!-- Mensaje-->
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="comentario" name="comentario" style="height: 10rem" data-sb-validations="required"><?= $comentario ?></textarea>
                            <label for="comentario">Mensaje</label>
                            <div class="invalid-feedback" data-sb-feedback="comentario:required">El mensaje es requerido.</div>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary btn-xl" id="submitButton" type="submit">Actualizar</button>
                        </div>
                    </form>
                    <a href="contacto.php">Volver</a>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

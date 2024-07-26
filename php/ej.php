<?php
include_once 'conexion.php';

$conexion_objeto = new Conexion();
$conexion = $conexion_objeto->ConexionBD();

if (!$conexion) {
    die("Error al conectar a la base de datos");
}
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
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <link href="/css/styles.css" rel="stylesheet" />
</head>
<body id="page-top">
    <!-- MENU -->
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
    <!-- Libros -->
    <section class="page-section bg-dark text-white">
        <div class="container px-4 px-lg-5 text-center">
            <h2 class="mb-4">Libros</h2>
        </div>
    </section>
    <!-- Listado de Libros -->
    <section class="page-section" id="libros">
        <div class="container px-4 px-lg-5">
            <h2 class="text-center mt-0">Listado de Libros</h2>
            <hr class="divider" />
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Tipo</th>
                                <th>Precio</th>
                                <th>Notas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include_once 'consultas.php';
                            $consultas = new Consultas($conexion);
                            $libros = $consultas->obtenerLibros();

                            // Verificar salida
                            foreach ($libros as $libro) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($libro['titulo']) . "</td>";
                                echo "<td>" . htmlspecialchars($libro['tipo']) . "</td>";
                                echo "<td>" . htmlspecialchars($libro['precio']) . "</td>";
                                echo "<td>" . htmlspecialchars($libro['notas']) . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Pie -->
    <footer class="bg-light py-5">
        <div class="container px-4 px-lg-5">
            <div class="small text-center text-muted">Copyright &copy; 2024 - Libreria DC</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>

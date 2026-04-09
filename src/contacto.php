<?php
require_once 'conexion.php';
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $asunto = trim($_POST['asunto'] ?? '');
    $comentario = trim($_POST['comentario'] ?? '');
    $fecha = date('Y-m-d H:i:s');

    if (!empty($nombre) && !empty($correo) && !empty($asunto) && !empty($comentario)) {
        try {
            $sql = "INSERT INTO contacto (fecha, correo, nombre, asunto, comentario) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$fecha, $correo, $nombre, $asunto, $comentario]);
            $mensaje = "<div class='alert alert-success'>Tu mensaje ha sido enviado y guardado correctamente.</div>";
        } catch (PDOException $e) {
            $mensaje = "<div class='alert alert-danger'>Error al guardar el mensaje: " . $e->getMessage() . "</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-warning'>Por favor, completa todos los campos.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería ITLA - Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Librería ITLA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Libros</a></li>
                    <li class="nav-item"><a class="nav-link" href="autores.php">Autores</a></li>
                    <li class="nav-item"><a class="nav-link active" href="contacto.php">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">Contáctanos</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php echo $mensaje; ?>
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form method="POST" action="contacto.php">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                            <div class="mb-3">
                                <label for="asunto" class="form-label">Asunto</label>
                                <input type="text" class="form-control" id="asunto" name="asunto" required>
                            </div>
                            <div class="mb-3">
                                <label for="comentario" class="form-label">Comentario</label>
                                <textarea class="form-control" id="comentario" name="comentario" rows="5" required></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Enviar Mensaje</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include 'footer.php'; ?>
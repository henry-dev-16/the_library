<?php
require_once 'conexion.php';

try {
    $stmt = $pdo->query("SELECT id_autor, nombre, apellido, telefono, ciudad, pais FROM autores");
    $autores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería ITLA - Autores</title>
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
                    <li class="nav-item"><a class="nav-link active" href="autores.php">Autores</a></li>
                    <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Listado de Autores</h2>
        <div class="table-responsive shadow-sm">
            <table class="table table-striped table-hover table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>Ciudad</th>
                        <th>País</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($autores as $autor): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($autor['id_autor']); ?></td>
                            <td><?php echo htmlspecialchars(trim($autor['nombre'])); ?></td>
                            <td><?php echo htmlspecialchars(trim($autor['apellido'])); ?></td>
                            <td><?php echo htmlspecialchars($autor['telefono']); ?></td>
                            <td><?php echo htmlspecialchars($autor['ciudad']); ?></td>
                            <td><?php echo htmlspecialchars($autor['pais']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php include 'footer.php'; ?>
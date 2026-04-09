<?php
require_once 'conexion.php';

try {
    $stmt = $pdo->query("SELECT id_titulo, titulo, tipo, precio, fecha_pub FROM titulos");
    $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Cumpliendo el requerimiento de count() y sizeof()
    $total_libros = count($libros);
    $total_libros_sizeof = sizeof($libros);
} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería ITLA - Libros</title>
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
                    <li class="nav-item"><a class="nav-link active" href="index.php">Libros</a></li>
                    <li class="nav-item"><a class="nav-link" href="autores.php">Autores</a></li>
                    <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Listado de Libros Disponibles</h2>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-success text-white shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Cómputo de Registros</h5>
                        <p class="card-text mb-0">
                            Total (usando count): <?php echo $total_libros; ?><br>
                            Total (usando sizeof): <?php echo $total_libros_sizeof; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="table-responsive shadow-sm">
            <table class="table table-striped table-hover table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Género</th>
                        <th>Precio</th>
                        <th>Fecha de Publicación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($libros as $libro): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($libro['id_titulo']); ?></td>
                            <td><?php echo htmlspecialchars($libro['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($libro['tipo']); ?></td>
                            <td>$<?php echo number_format((float)$libro['precio'], 2); ?></td>
                            <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($libro['fecha_pub']))); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php include 'footer.php'; ?>

# Proyecto Final ITLA: Libreria Web Completa

A continuacion se presenta la totalidad del proyecto documentado y estructurado en formato Markdown. Puedes copiar el contenido de cada bloque de codigo y guardarlo en su archivo correspondiente.

## 1. Estructura de Directorios

**Plaintext**

```
libreria_itla/
├── docker-compose.yml
├── Dockerfile
├── README.md
├── db/
│   ├── Base Datos Libreria.sql
│   └── 02_contacto.sql
└── src/
    ├── assets/
    │   ├── css/
    │   │   └── style.css
    │   └── js/
    │       └── main.js
    ├── conexion.php
    ├── index.php
    ├── autores.php
    ├── contacto.php
    └── footer.php
```

---

## 2. Archivos de Configuracion Docker

### `docker-compose.yml`

**YAML**

```
version: '3.8'

services:
  web:
    build: .
    container_name: php_web
    ports:
      - "8080:80"
    volumes:
      - ./src:/var/www/html
    depends_on:
      - db

  db:
    image: mysql:5.7
    container_name: mysql_db
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: dblibreria
      MYSQL_USER: admin
      MYSQL_PASSWORD: adminpassword
    ports:
      - "3306:3306"
    volumes:
      - ./db:/docker-entrypoint-initdb.d
      - db_data:/var/lib/mysql

volumes:
  db_data:
```

### `Dockerfile`

**Dockerfile**

```
FROM php:8.2-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite
RUN chown -R www-data:www-data /var/www/html
```

---

## 3. Archivos de Base de Datos

### `db/02_contacto.sql`

*(Nota: Guarda el archivo `Base Datos Libreria.sql` original en esta misma carpeta `db`)*

**SQL**

```
CREATE TABLE IF NOT EXISTS `contacto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `correo` varchar(150) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `asunto` varchar(150) NOT NULL,
  `comentario` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

---

## 4. Archivos Frontend (Recursos CSS y JS)

### `src/assets/css/style.css`

**CSS**

```
body {
    background-color: #f8f9fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.navbar {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}
.table-hover tbody tr:hover {
    background-color: #e9ecef;
    transition: background-color 0.3s ease;
}
.card {
    border-radius: 10px;
    border: none;
}
.badge-custom {
    font-size: 1rem;
    padding: 0.5em 0.8em;
}
```

### `src/assets/js/main.js`

**JavaScript**

```
document.addEventListener("DOMContentLoaded", function() {
    const formContacto = document.querySelector("form[action='contacto.php']");
    if (formContacto) {
        formContacto.addEventListener("submit", function(event) {
            const comentario = document.getElementById("comentario").value;
            if (comentario.trim().length < 10) {
                event.preventDefault();
                alert("Por favor, el comentario debe tener al menos 10 caracteres.");
            }
        });
    }
});
```

---

## 5. Archivos de Logica PHP y Vistas Web

### `src/conexion.php`

**PHP**

```
<?php
$host = 'db'; // Cambiar por el host remoto en produccion
$dbname = 'dblibreria';
$username = 'admin'; // Cambiar por usuario remoto en produccion
$password = 'adminpassword'; // Cambiar por password remoto en produccion

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexion: " . $e->getMessage());
}
?>
```

### `src/footer.php`

**PHP**

```
    <footer class="bg-dark text-white pt-4 pb-2 mt-5">
        <div class="container text-center">
            <p>Libreria ITLA © <?php echo date('Y'); ?> - Proyecto Final Programacion Web</p>
            <div class="mb-2">
                <small>Desarrollado con: PHP, PDO, MySQL, Bootstrap y Docker</small>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
```

### `src/index.php`

**PHP**

```
<?php
require_once 'conexion.php';

try {
    $stmt = $pdo->query("SELECT id_titulo, titulo, tipo, precio, fecha_pub FROM titulos");
    $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
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
    <title>Libreria ITLA - Libros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Libreria ITLA</a>
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
                        <h5 class="card-title">Computo de Registros</h5>
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
                        <th>Titulo</th>
                        <th>Genero</th>
                        <th>Precio</th>
                        <th>Fecha de Publicacion</th>
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
```

### `src/autores.php`

**PHP**

```
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
    <title>Libreria ITLA - Autores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Libreria ITLA</a>
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
                        <th>Telefono</th>
                        <th>Ciudad</th>
                        <th>Pais</th>
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
```

### `src/contacto.php`

**PHP**

```
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
    <title>Libreria ITLA - Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Libreria ITLA</a>
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
        <h2 class="mb-4 text-center">Contactanos</h2>
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
                                <label for="correo" class="form-label">Correo Electronico</label>
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
```

---

## 6. Documentacion (README.md)

### `README.md`

**Markdown**

```
# Proyecto Final: Libreria ITLA

Este repositorio contiene el codigo fuente del Proyecto Final para la asignatura de Programacion Web del ITLA (Instituto Tecnologico de Las Americas), impartida por el profesor Daniel Parra.

## Objetivo del Proyecto
Utilizar y combinar las tecnologias de HTML, CSS, Javascript, PHP y MySQL para crear un portal web que permita consultar el listado de libros y autores disponibles en una libreria online, aplicando las mejores practicas y requerimientos academicos establecidos.

## Caracteristicas Principales

- Catalogo de Libros: Visualizacion de titulos disponibles, genero, precios y fechas de publicacion.
- Directorio de Autores: Listado completo de los autores registrados en la base de datos.
- Formulario de Contacto: Sistema funcional que valida datos con JavaScript y los almacena en la base de datos usando PHP.
- Estadisticas Dinamicas: Implementacion de funciones nativas de PHP (count() y sizeof()) para el conteo de registros.
- Diseno Responsivo: Interfaz adaptable a cualquier dispositivo movil o de escritorio gracias a Bootstrap 5.

## Tecnologias y Herramientas

- Frontend: HTML5, CSS3 (Personalizado), JavaScript (Validacion en cliente), Bootstrap 5.3.2.
- Backend: PHP 8.2 utilizando el paradigma de objetos de datos (PDO) para consultas seguras.
- Base de Datos: MySQL (Motor MyISAM/InnoDB con charset latin1/utf8).
- Entorno de Desarrollo: Docker & Docker Compose para contenerizacion y despliegue local automatizado.

## Requisitos Cumplidos (Rubrica de Evaluacion)

- [x] Portal web completamente en espanol.
- [x] Uso de plantilla Bootstrap.
- [x] Conexiones y consultas a base de datos utilizando PDO.
- [x] Uso del metodo POST para el envio del formulario.
- [x] Uso del ciclo foreach para la impresion de datos.
- [x] Implementacion de las funciones count() y sizeof().
- [x] CSS y JavaScript propios integrados.
- [x] Base de datos estructurada (titulos, autores y contacto).

## Como ejecutar este proyecto localmente

Este proyecto utiliza Docker para facilitar su despliegue local sin necesidad de instalar XAMPP o WAMP.

1. Clona este repositorio:
   ```bash
   git clone [https://github.com/tu-usuario/tu-repositorio.git](https://github.com/tu-usuario/tu-repositorio.git)
   cd tu-repositorio
```

2. Levanta los contenedores con Docker Compose:
   **Bash**

   ```
   docker compose up -d --build
   ```
3. Abre tu navegador e ingresa a:
   **Plaintext**

   ```
   http://localhost:8080
   ```

Nota: La base de datos y las tablas se crearan e importaran automaticamente al iniciar el contenedor de MySQL gracias al mapeo del directorio ./db.

## Despliegue en Produccion

Para desplegar este proyecto en un hosting publico gratuito (ej. InfinityFree):

1. Exportar la base de datos generada localmente.
2. Importarla a traves de phpMyAdmin en el servidor remoto.
3. Actualizar el archivo src/conexion.php con las credenciales (Host, User, Password, DBName) provistas por el hosting.
4. Subir unicamente el contenido del directorio src/ a la carpeta htdocs o public_html del servidor mediante FTP o Administrador de Archivos.

---

Desarrollado para fines academicos - ITLA 2026

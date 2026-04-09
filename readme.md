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

- [X] Portal web completamente en espanol.
- [X] Uso de plantilla Bootstrap.
- [X] Conexiones y consultas a base de datos utilizando PDO.
- [X] Uso del metodo POST para el envio del formulario.
- [X] Uso del ciclo foreach para la impresion de datos.
- [X] Implementacion de las funciones count() y sizeof().
- [X] CSS y JavaScript propios integrados.
- [X] Base de datos estructurada (titulos, autores y contacto).

## Como ejecutar este proyecto localmente

Este proyecto utiliza Docker para facilitar su despliegue local sin necesidad de instalar XAMPP o WAMP.

1. Clona este repositorio:
   ```bash
   git clone https://github.com/henry-dev-16/the_library
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

document.addEventListener('DOMContentLoaded', function() {

    var tablaLibros = document.getElementById('tablaLibros');
    if (tablaLibros) {
        cargarLibros();
    }

    var tablaAutores = document.getElementById('tablaAutores');
    if (tablaAutores) {
        cargarAutores();
    }

    var formContacto = document.getElementById('formContacto');
    if (formContacto) {
        formContacto.addEventListener('submit', function(e) {
            e.preventDefault();
            enviarContacto();
        });
    }

});

function cargarLibros() {
    fetch('api/libros.php')
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            document.getElementById('totalCount').textContent = data.total_count;
            document.getElementById('totalSizeof').textContent = data.total_sizeof;

            var tbody = document.getElementById('tablaLibros');
            tbody.innerHTML = '';

            for (var i = 0; i < data.libros.length; i++) {
                var libro = data.libros[i];
                var tr = document.createElement('tr');

                var fecha = new Date(libro.fecha_pub);
                var fechaFormateada = fecha.getDate().toString().padStart(2, '0') + '/' +
                    (fecha.getMonth() + 1).toString().padStart(2, '0') + '/' +
                    fecha.getFullYear();

                var precio = parseFloat(libro.precio).toFixed(2);

                tr.innerHTML =
                    '<td>' + libro.id_titulo + '</td>' +
                    '<td>' + libro.titulo + '</td>' +
                    '<td>' + libro.tipo + '</td>' +
                    '<td>$' + precio + '</td>' +
                    '<td>' + fechaFormateada + '</td>';

                tbody.appendChild(tr);
            }
        });
}

function cargarAutores() {
    fetch('api/autores.php')
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            var tbody = document.getElementById('tablaAutores');
            tbody.innerHTML = '';

            for (var i = 0; i < data.autores.length; i++) {
                var autor = data.autores[i];
                var tr = document.createElement('tr');

                tr.innerHTML =
                    '<td>' + autor.id_autor + '</td>' +
                    '<td>' + autor.nombre + '</td>' +
                    '<td>' + autor.apellido + '</td>' +
                    '<td>' + autor.telefono + '</td>' +
                    '<td>' + autor.ciudad + '</td>' +
                    '<td>' + autor.pais + '</td>';

                tbody.appendChild(tr);
            }
        });
}

function enviarContacto() {
    var nombre = document.getElementById('nombre').value.trim();
    var correo = document.getElementById('correo').value.trim();
    var asunto = document.getElementById('asunto').value.trim();
    var comentario = document.getElementById('comentario').value.trim();

    if (nombre === '' || correo === '' || asunto === '' || comentario === '') {
        mostrarAlerta('danger', 'Por favor, completa todos los campos.');
        return;
    }

    if (nombre.length < 3) {
        mostrarAlerta('danger', 'El nombre debe tener al menos 3 caracteres.');
        return;
    }

    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(correo)) {
        mostrarAlerta('danger', 'Por favor, ingresa un correo electronico valido.');
        return;
    }

    if (comentario.length < 10) {
        mostrarAlerta('danger', 'El comentario debe tener al menos 10 caracteres.');
        return;
    }

    fetch('api/contacto.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            nombre: nombre,
            correo: correo,
            asunto: asunto,
            comentario: comentario
        })
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        if (data.exito) {
            mostrarAlerta('success', data.mensaje);
            document.getElementById('formContacto').reset();
        } else {
            mostrarAlerta('danger', data.mensaje);
        }
    });
}

function mostrarAlerta(tipo, mensaje) {
    var div = document.getElementById('mensajeAlerta');
    div.innerHTML = '<div class="alert alert-' + tipo + '">' + mensaje + '</div>';
}

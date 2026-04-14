<?php

require_once '../classes/Database.php';
require_once '../classes/Contacto.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datos = json_decode(file_get_contents('php://input'), true);

    $nombre = trim($datos['nombre'] ?? '');
    $correo = trim($datos['correo'] ?? '');
    $asunto = trim($datos['asunto'] ?? '');
    $comentario = trim($datos['comentario'] ?? '');

    if (!empty($nombre) && !empty($correo) && !empty($asunto) && !empty($comentario)) {
        $db = new Database();
        $contacto = new Contacto($db->getConexion());

        if ($contacto->guardar($nombre, $correo, $asunto, $comentario)) {
            echo json_encode(['exito' => true, 'mensaje' => 'Tu mensaje ha sido enviado y guardado correctamente.']);
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'Error al guardar el mensaje.']);
        }
    } else {
        echo json_encode(['exito' => false, 'mensaje' => 'Por favor, completa todos los campos.']);
    }
} else {
    echo json_encode(['exito' => false, 'mensaje' => 'Metodo no permitido.']);
}

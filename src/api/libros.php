<?php

require_once '../classes/Database.php';
require_once '../classes/Libro.php';

header('Content-Type: application/json');

$db = new Database();
$libro = new Libro($db->getConexion());
$libros = $libro->obtenerTodos();

$total_count = count($libros);
$total_sizeof = sizeof($libros);

$respuesta = [
    'libros' => $libros,
    'total_count' => $total_count,
    'total_sizeof' => $total_sizeof
];

echo json_encode($respuesta);

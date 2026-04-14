<?php

require_once '../classes/Database.php';
require_once '../classes/Autor.php';

header('Content-Type: application/json');

$db = new Database();
$autor = new Autor($db->getConexion());
$autores = $autor->obtenerTodos();

foreach ($autores as &$a) {
    $a['nombre'] = trim($a['nombre']);
    $a['apellido'] = trim($a['apellido']);
}

echo json_encode(['autores' => $autores]);

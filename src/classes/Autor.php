<?php

class Autor {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerTodos() {
        try {
            $stmt = $this->pdo->query("SELECT id_autor, nombre, apellido, telefono, ciudad, pais FROM autores");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
        }
    }
}

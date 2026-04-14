<?php

class Contacto {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function guardar($nombre, $correo, $asunto, $comentario) {
        try {
            $fecha = date('Y-m-d H:i:s');
            $sql = "INSERT INTO contacto (fecha, correo, nombre, asunto, comentario) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$fecha, $correo, $nombre, $asunto, $comentario]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}

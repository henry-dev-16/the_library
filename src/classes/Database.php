<?php

class Database {
    private $host = 'db';
    private $dbname = 'dblibreria';
    private $username = 'admin';
    private $password = 'adminpassword';
    private $conexion;

    public function __construct() {
        try {
            $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexion: " . $e->getMessage());
        }
    }

    public function getConexion() {
        return $this->conexion;
    }
}

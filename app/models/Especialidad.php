<?php
require_once __DIR__ . "/../../config/conexion.php";

class Especialidad
{
    public static function obtenerTodas()
    {
        $pdo = obtenerConexion();
        $sql = "SELECT * FROM especialidades ORDER BY nombre";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    public static function obtenerPorId($id)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT * FROM especialidades WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }
}

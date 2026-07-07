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

    public static function crear($datos)
    {
        $pdo = obtenerConexion();
        $sql = "INSERT INTO especialidades (nombre) VALUES (:nombre)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([":nombre" => $datos["nombre"]]);
    }

    public static function actualizar($id, $datos)
    {
        $pdo = obtenerConexion();
        $sql = "UPDATE especialidades SET nombre = :nombre WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([":id" => $id, ":nombre" => $datos["nombre"]]);
    }

    public static function eliminar($id)
    {
        $pdo = obtenerConexion();
        $sql = "DELETE FROM especialidades WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }

    public static function tieneMedicosAsociados($id)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT COUNT(*) FROM medicos WHERE especialidad_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetchColumn() > 0;
    }

    public static function tieneServiciosAsociados($id)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT COUNT(*) FROM servicios WHERE especialidad_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetchColumn() > 0;
    }
}

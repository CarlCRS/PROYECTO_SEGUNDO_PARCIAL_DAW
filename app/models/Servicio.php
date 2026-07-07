<?php
require_once __DIR__ . "/../../config/conexion.php";

class Servicio
{
    public static function obtenerPorEspecialidad($especialidadId)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT s.*, e.nombre AS especialidad_nombre
                FROM servicios s
                JOIN especialidades e ON s.especialidad_id = e.id
                WHERE s.especialidad_id = :especialidad_id
                ORDER BY s.nombre";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":especialidad_id" => $especialidadId]);
        return $stmt->fetchAll();
    }

    public static function obtenerPorId($id)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT s.*, e.nombre AS especialidad_nombre
                FROM servicios s
                JOIN especialidades e ON s.especialidad_id = e.id
                WHERE s.id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    public static function crear($datos)
    {
        $pdo = obtenerConexion();
        $sql = "INSERT INTO servicios (especialidad_id, nombre, tarifa)
                VALUES (:especialidad_id, :nombre, :tarifa)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":especialidad_id" => $datos["especialidad_id"],
            ":nombre"          => $datos["nombre"],
            ":tarifa"          => $datos["tarifa"],
        ]);
    }

    public static function actualizar($id, $datos)
    {
        $pdo = obtenerConexion();
        $sql = "UPDATE servicios SET
                    nombre = :nombre,
                    tarifa = :tarifa
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":id"     => $id,
            ":nombre" => $datos["nombre"],
            ":tarifa" => $datos["tarifa"],
        ]);
    }

    public static function eliminar($id)
    {
        $pdo = obtenerConexion();
        $sql = "DELETE FROM servicios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }
}

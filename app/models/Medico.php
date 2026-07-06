<?php
require_once __DIR__ . "/../../config/conexion.php";

class Medico
{
    public static function obtenerTodos()
    {
        $pdo = obtenerConexion();
        $sql = "SELECT m.*, e.nombre AS especialidad_nombre, u.nombre AS usuario_nombre
                FROM medicos m
                LEFT JOIN especialidades e ON m.especialidad_id = e.id
                LEFT JOIN usuarios u ON m.usuario_id = u.id
                ORDER BY m.nombre";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    public static function obtenerPorId($id)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT m.*, e.nombre AS especialidad_nombre, u.nombre AS usuario_nombre
                FROM medicos m
                LEFT JOIN especialidades e ON m.especialidad_id = e.id
                LEFT JOIN usuarios u ON m.usuario_id = u.id
                WHERE m.id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    public static function crear($datos)
    {
        $pdo = obtenerConexion();
        $sql = "INSERT INTO medicos (usuario_id, nombre, especialidad_id, telefono)
                VALUES (:usuario_id, :nombre, :especialidad_id, :telefono)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":usuario_id"       => $datos["usuario_id"],
            ":nombre"           => $datos["nombre"],
            ":especialidad_id"  => $datos["especialidad_id"],
            ":telefono"         => $datos["telefono"],
        ]);
    }

    public static function actualizar($id, $datos)
    {
        $pdo = obtenerConexion();
        $sql = "UPDATE medicos SET
                    usuario_id = :usuario_id,
                    nombre = :nombre,
                    especialidad_id = :especialidad_id,
                    telefono = :telefono
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":id"               => $id,
            ":usuario_id"       => $datos["usuario_id"],
            ":nombre"           => $datos["nombre"],
            ":especialidad_id"  => $datos["especialidad_id"],
            ":telefono"         => $datos["telefono"],
        ]);
    }

    public static function eliminar($id)
    {
        $pdo = obtenerConexion();
        $sql = "DELETE FROM medicos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }

    public static function tieneCitasActivas($id)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT COUNT(*) FROM citas
                WHERE medico_id = :medico_id AND estado IN ('pendiente', 'confirmada')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":medico_id" => $id]);
        return $stmt->fetchColumn() > 0;
    }
}

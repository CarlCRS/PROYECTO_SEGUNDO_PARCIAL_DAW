<?php
require_once __DIR__ . "/../../config/conexion.php";

class Antecedente
{
    public static function obtenerPorPaciente($pacienteId)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT a.*, p.nombre AS paciente_nombre
                FROM antecedentes a
                JOIN pacientes p ON a.paciente_id = p.id
                WHERE a.paciente_id = :paciente_id
                ORDER BY a.fecha_registro DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":paciente_id" => $pacienteId]);
        return $stmt->fetchAll();
    }

    public static function obtenerPorId($id)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT a.*, p.nombre AS paciente_nombre
                FROM antecedentes a
                JOIN pacientes p ON a.paciente_id = p.id
                WHERE a.id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    public static function crear($datos)
    {
        $pdo = obtenerConexion();
        $sql = "INSERT INTO antecedentes (paciente_id, descripcion, fecha_registro)
                VALUES (:paciente_id, :descripcion, :fecha_registro)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":paciente_id"    => $datos["paciente_id"],
            ":descripcion"    => $datos["descripcion"],
            ":fecha_registro" => $datos["fecha_registro"],
        ]);
    }

    public static function actualizar($id, $datos)
    {
        $pdo = obtenerConexion();
        $sql = "UPDATE antecedentes SET
                    descripcion = :descripcion,
                    fecha_registro = :fecha_registro
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":id"             => $id,
            ":descripcion"    => $datos["descripcion"],
            ":fecha_registro" => $datos["fecha_registro"],
        ]);
    }

    public static function eliminar($id)
    {
        $pdo = obtenerConexion();
        $sql = "DELETE FROM antecedentes WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }
}

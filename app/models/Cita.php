<?php
require_once __DIR__ . "/../../config/conexion.php";

class Cita
{
    public static function obtenerTodas()
    {
        $pdo = obtenerConexion();
        $sql = "SELECT c.*, p.nombre AS paciente_nombre, m.nombre AS medico_nombre, e.nombre AS especialidad_nombre
                FROM citas c
                JOIN pacientes p ON c.paciente_id = p.id
                JOIN medicos m ON c.medico_id = m.id
                LEFT JOIN especialidades e ON m.especialidad_id = e.id
                ORDER BY c.fecha DESC, c.hora DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    public static function obtenerPorMedico($medicoId)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT c.*, p.nombre AS paciente_nombre, m.nombre AS medico_nombre, e.nombre AS especialidad_nombre
                FROM citas c
                JOIN pacientes p ON c.paciente_id = p.id
                JOIN medicos m ON c.medico_id = m.id
                LEFT JOIN especialidades e ON m.especialidad_id = e.id
                WHERE c.medico_id = :medico_id
                ORDER BY c.fecha DESC, c.hora DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":medico_id" => $medicoId]);
        return $stmt->fetchAll();
    }

    public static function obtenerPorPaciente($pacienteId)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT c.*, p.nombre AS paciente_nombre, m.nombre AS medico_nombre, e.nombre AS especialidad_nombre
                FROM citas c
                JOIN pacientes p ON c.paciente_id = p.id
                JOIN medicos m ON c.medico_id = m.id
                LEFT JOIN especialidades e ON m.especialidad_id = e.id
                WHERE c.paciente_id = :paciente_id
                ORDER BY c.fecha DESC, c.hora DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":paciente_id" => $pacienteId]);
        return $stmt->fetchAll();
    }

    public static function obtenerPorId($id)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT c.*, p.nombre AS paciente_nombre, m.nombre AS medico_nombre, e.nombre AS especialidad_nombre
                FROM citas c
                JOIN pacientes p ON c.paciente_id = p.id
                JOIN medicos m ON c.medico_id = m.id
                LEFT JOIN especialidades e ON m.especialidad_id = e.id
                WHERE c.id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    public static function crear($datos)
    {
        $pdo = obtenerConexion();
        $sql = "INSERT INTO citas (paciente_id, medico_id, fecha, hora, motivo)
                VALUES (:paciente_id, :medico_id, :fecha, :hora, :motivo)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":paciente_id" => $datos["paciente_id"],
            ":medico_id"   => $datos["medico_id"],
            ":fecha"       => $datos["fecha"],
            ":hora"        => $datos["hora"],
            ":motivo"      => $datos["motivo"],
        ]);
    }

    public static function actualizar($id, $datos)
    {
        $pdo = obtenerConexion();
        $sql = "UPDATE citas SET
                    paciente_id = :paciente_id,
                    medico_id = :medico_id,
                    fecha = :fecha,
                    hora = :hora,
                    estado = :estado,
                    motivo = :motivo
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":id"          => $id,
            ":paciente_id" => $datos["paciente_id"],
            ":medico_id"   => $datos["medico_id"],
            ":fecha"       => $datos["fecha"],
            ":hora"        => $datos["hora"],
            ":estado"      => $datos["estado"],
            ":motivo"      => $datos["motivo"],
        ]);
    }

    public static function cancelar($id)
    {
        $pdo = obtenerConexion();
        $sql = "UPDATE citas SET estado = 'cancelada' WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }

    public static function existeCruceHorario($medicoId, $fecha, $hora, $excluirId = null)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT COUNT(*) FROM citas
                WHERE medico_id = :medico_id AND fecha = :fecha AND hora = :hora
                AND estado != 'cancelada'";
        $params = [":medico_id" => $medicoId, ":fecha" => $fecha, ":hora" => $hora];
        if ($excluirId !== null) {
            $sql .= " AND id != :id";
            $params[":id"] = $excluirId;
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public static function obtenerPacientes()
    {
        $pdo = obtenerConexion();
        $sql = "SELECT id, nombre, cedula FROM pacientes ORDER BY nombre";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    public static function obtenerMedicos()
    {
        $pdo = obtenerConexion();
        $sql = "SELECT m.id, m.nombre, e.nombre AS especialidad_nombre
                FROM medicos m
                LEFT JOIN especialidades e ON m.especialidad_id = e.id
                ORDER BY m.nombre";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }
}

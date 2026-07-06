<?php
require_once __DIR__ . "/../../config/conexion.php";

class Horario
{
    public static function obtenerPorMedico($medicoId)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT h.*, m.nombre AS medico_nombre
                FROM horarios h
                JOIN medicos m ON h.medico_id = m.id
                WHERE h.medico_id = :medico_id
                ORDER BY FIELD(dia_semana, 'lunes','martes','miercoles','jueves','viernes','sabado'), hora_inicio";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":medico_id" => $medicoId]);
        return $stmt->fetchAll();
    }

    public static function obtenerPorId($id)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT h.*, m.nombre AS medico_nombre
                FROM horarios h
                JOIN medicos m ON h.medico_id = m.id
                WHERE h.id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    public static function crear($datos)
    {
        $pdo = obtenerConexion();
        $sql = "INSERT INTO horarios (medico_id, dia_semana, hora_inicio, hora_fin)
                VALUES (:medico_id, :dia_semana, :hora_inicio, :hora_fin)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":medico_id"   => $datos["medico_id"],
            ":dia_semana"  => $datos["dia_semana"],
            ":hora_inicio" => $datos["hora_inicio"],
            ":hora_fin"    => $datos["hora_fin"],
        ]);
    }

    public static function actualizar($id, $datos)
    {
        $pdo = obtenerConexion();
        $sql = "UPDATE horarios SET
                    dia_semana = :dia_semana,
                    hora_inicio = :hora_inicio,
                    hora_fin = :hora_fin
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":id"          => $id,
            ":dia_semana"  => $datos["dia_semana"],
            ":hora_inicio" => $datos["hora_inicio"],
            ":hora_fin"    => $datos["hora_fin"],
        ]);
    }

    public static function eliminar($id)
    {
        $pdo = obtenerConexion();
        $sql = "DELETE FROM horarios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }
}

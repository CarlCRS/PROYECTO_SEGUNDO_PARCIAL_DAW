<?php
require_once __DIR__ . "/../../config/conexion.php";

class Pago
{
    public static function obtenerPorCita($citaId)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT p.*, c.fecha AS cita_fecha, c.hora AS cita_hora,
                       pac.nombre AS paciente_nombre, m.nombre AS medico_nombre
                FROM pagos p
                JOIN citas c ON p.cita_id = c.id
                JOIN pacientes pac ON c.paciente_id = pac.id
                JOIN medicos m ON c.medico_id = m.id
                WHERE p.cita_id = :cita_id
                ORDER BY p.fecha_pago DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":cita_id" => $citaId]);
        return $stmt->fetchAll();
    }

    public static function obtenerPorId($id)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT p.*, c.fecha AS cita_fecha, c.hora AS cita_hora,
                       pac.nombre AS paciente_nombre, m.nombre AS medico_nombre
                FROM pagos p
                JOIN citas c ON p.cita_id = c.id
                JOIN pacientes pac ON c.paciente_id = pac.id
                JOIN medicos m ON c.medico_id = m.id
                WHERE p.id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    public static function crear($datos, $pdo = null)
    {
        if ($pdo === null) {
            $pdo = obtenerConexion();
        }
        $sql = "INSERT INTO pagos (cita_id, monto, estado_pago, metodo_pago, fecha_pago)
                VALUES (:cita_id, :monto, :estado_pago, :metodo_pago, :fecha_pago)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":cita_id"     => $datos["cita_id"],
            ":monto"       => $datos["monto"],
            ":estado_pago" => $datos["estado_pago"] ?? "pendiente",
            ":metodo_pago" => $datos["metodo_pago"] ?? "pendiente",
            ":fecha_pago"  => $datos["fecha_pago"],
        ]);
    }

    public static function actualizar($id, $datos)
    {
        $pdo = obtenerConexion();
        $sql = "UPDATE pagos SET
                    monto = :monto,
                    estado_pago = :estado_pago,
                    metodo_pago = :metodo_pago,
                    fecha_pago = :fecha_pago
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":id"          => $id,
            ":monto"       => $datos["monto"],
            ":estado_pago" => $datos["estado_pago"],
            ":metodo_pago" => $datos["metodo_pago"],
            ":fecha_pago"  => $datos["fecha_pago"],
        ]);
    }

    public static function actualizarMontoPorCita($citaId, $nuevoMonto, $pdo = null)
    {
        if ($pdo === null) {
            $pdo = obtenerConexion();
        }
        $sql = "UPDATE pagos SET monto = :monto WHERE cita_id = :cita_id AND estado_pago = 'pendiente'";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([":monto" => $nuevoMonto, ":cita_id" => $citaId]);
    }

    public static function cancelarPorCita($citaId)
    {
        $pdo = obtenerConexion();
        $sql = "UPDATE pagos SET estado_pago = 'cancelado' WHERE cita_id = :cita_id AND estado_pago != 'cancelado'";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([":cita_id" => $citaId]);
    }

    public static function eliminar($id)
    {
        $pdo = obtenerConexion();
        $sql = "DELETE FROM pagos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }
}

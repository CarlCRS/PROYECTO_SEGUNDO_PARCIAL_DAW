<?php
require_once __DIR__ . "/../../config/conexion.php";

class Paciente
{
    public static function obtenerTodos()
    {
        $pdo = obtenerConexion();
        $sql = "SELECT p.*, u.nombre AS usuario_nombre
                FROM pacientes p
                LEFT JOIN usuarios u ON p.usuario_id = u.id
                ORDER BY p.nombre";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    public static function obtenerPorId($id)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT p.*, u.nombre AS usuario_nombre
                FROM pacientes p
                LEFT JOIN usuarios u ON p.usuario_id = u.id
                WHERE p.id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    public static function crear($datos)
    {
        $pdo = obtenerConexion();
        $sql = "INSERT INTO pacientes (usuario_id, nombre, cedula, telefono, fecha_nacimiento)
                VALUES (:usuario_id, :nombre, :cedula, :telefono, :fecha_nacimiento)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":usuario_id"       => $datos["usuario_id"],
            ":nombre"           => $datos["nombre"],
            ":cedula"           => $datos["cedula"],
            ":telefono"         => $datos["telefono"],
            ":fecha_nacimiento" => $datos["fecha_nacimiento"],
        ]);
    }

    public static function actualizar($id, $datos)
    {
        $pdo = obtenerConexion();
        $sql = "UPDATE pacientes SET
                    usuario_id = :usuario_id,
                    nombre = :nombre,
                    cedula = :cedula,
                    telefono = :telefono,
                    fecha_nacimiento = :fecha_nacimiento
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":id"               => $id,
            ":usuario_id"       => $datos["usuario_id"],
            ":nombre"           => $datos["nombre"],
            ":cedula"           => $datos["cedula"],
            ":telefono"         => $datos["telefono"],
            ":fecha_nacimiento" => $datos["fecha_nacimiento"],
        ]);
    }

    public static function eliminar($id)
    {
        $pdo = obtenerConexion();
        $sql = "DELETE FROM pacientes WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }

    public static function obtenerPorUsuarioId($usuarioId)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT * FROM pacientes WHERE usuario_id = :usuario_id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":usuario_id" => $usuarioId]);
        return $stmt->fetch();
    }

    public static function existeCedula($cedula, $excluirId = null)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT COUNT(*) FROM pacientes WHERE cedula = :cedula";
        $params = [":cedula" => $cedula];
        if ($excluirId !== null) {
            $sql .= " AND id != :id";
            $params[":id"] = $excluirId;
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
}

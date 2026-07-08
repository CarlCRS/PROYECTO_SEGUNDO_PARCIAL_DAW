<?php
require_once __DIR__ . "/../../config/conexion.php";

class Usuario
{
    public static function obtenerPorEmail($email)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":email" => $email]);
        return $stmt->fetch();
    }

    public static function crear($datos)
    {
        $pdo = obtenerConexion();
        $sql = "INSERT INTO usuarios (nombre, email, password, rol)
                VALUES (:nombre, :email, :password, :rol)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":nombre"   => $datos["nombre"],
            ":email"    => $datos["email"],
            ":password" => password_hash($datos["password"], PASSWORD_DEFAULT),
            ":rol"      => $datos["rol"] ?? "admin",
        ]);
    }

    public static function obtenerPorId($id)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT id, nombre, email FROM usuarios WHERE id = :id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    public static function existeEmail($email)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":email" => $email]);
        return $stmt->fetchColumn() > 0;
    }

    public static function obtenerPorRol($rol)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT id, nombre, email FROM usuarios WHERE rol = :rol ORDER BY nombre";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":rol" => $rol]);
        return $stmt->fetchAll();
    }

    public static function obtenerPorRolNoVinculadoMedico($rol)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT u.id, u.nombre, u.email
                FROM usuarios u
                WHERE u.rol = :rol
                AND u.id NOT IN (SELECT usuario_id FROM medicos WHERE usuario_id IS NOT NULL)
                ORDER BY u.nombre";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":rol" => $rol]);
        return $stmt->fetchAll();
    }

    public static function obtenerPorRolNoVinculadoPaciente($rol)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT u.id, u.nombre, u.email
                FROM usuarios u
                WHERE u.rol = :rol
                AND u.id NOT IN (SELECT usuario_id FROM pacientes WHERE usuario_id IS NOT NULL)
                ORDER BY u.nombre";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":rol" => $rol]);
        return $stmt->fetchAll();
    }
}

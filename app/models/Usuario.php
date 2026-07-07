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

    public static function existeEmail($email)
    {
        $pdo = obtenerConexion();
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":email" => $email]);
        return $stmt->fetchColumn() > 0;
    }
}

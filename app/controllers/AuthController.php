<?php
require_once __DIR__ . "/../models/Usuario.php";
require_once __DIR__ . "/../models/Paciente.php";

class AuthController
{
    public function login()
    {
        if (isset($_SESSION["usuario"])) {
            header("Location: ?url=inicio");
            exit;
        }
    }

    public function autenticar()
    {
        $email = trim($_POST["email"] ?? "");
        $password = trim($_POST["password"] ?? "");
        $errores = [];

        if ($email === "" || $password === "") {
            $errores[] = "Complete todos los campos";
            return ["errores" => $errores];
        }

        $usuario = Usuario::obtenerPorEmail($email);

        if (!$usuario || !password_verify($password, $usuario["password"])) {
            $errores[] = "Credenciales incorrectas";
            return ["errores" => $errores];
        }

        $_SESSION["usuario"] = $usuario["nombre"];
        $_SESSION["id_usuario"] = $usuario["id"];
        $_SESSION["rol"] = $usuario["rol"];

        header("Location: ?url=inicio");
        exit;
    }

    public function registro()
    {
        if (isset($_SESSION["usuario"])) {
            header("Location: ?url=inicio");
            exit;
        }
    }

    public function registrar()
    {
        $nombre = trim($_POST["nombre"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $password = trim($_POST["password"] ?? "");
        $cedula = trim($_POST["cedula"] ?? "");
        $telefono = trim($_POST["telefono"] ?? "");
        $errores = [];

        if ($nombre === "" || $email === "" || $password === "" || $cedula === "") {
            $errores[] = "Complete todos los campos obligatorios";
            return ["errores" => $errores];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "Correo electronico invalido";
            return ["errores" => $errores];
        }

        if (Usuario::existeEmail($email)) {
            $errores[] = "Ese correo ya esta registrado";
            return ["errores" => $errores];
        }

        if (Paciente::existeCedula($cedula)) {
            $errores[] = "Esa cedula ya esta registrada";
            return ["errores" => $errores];
        }

        if (strlen($password) < 6) {
            $errores[] = "La contraseña debe tener al menos 6 caracteres";
            return ["errores" => $errores];
        }

        $datos = [
            "nombre"   => htmlspecialchars($nombre),
            "email"    => $email,
            "password" => $password,
            "rol"      => "paciente",
        ];

        $usuarioId = Usuario::crear($datos);
        if (!$usuarioId) {
            $errores[] = "Error al registrar el usuario";
            return ["errores" => $errores];
        }

        $pacienteDatos = [
            "usuario_id"       => $usuarioId,
            "nombre"           => htmlspecialchars($nombre),
            "cedula"           => htmlspecialchars($cedula),
            "telefono"         => htmlspecialchars($telefono),
            "fecha_nacimiento" => null,
        ];

        if (!Paciente::crear($pacienteDatos)) {
            $errores[] = "Error al crear el perfil de paciente";
            return ["errores" => $errores];
        }

        header("Location: ?url=auth/login&msg=" . urlencode("Registro exitoso. Inicie sesion"));
        exit;
    }

    public function logout()
    {
        session_destroy();
        header("Location: ?url=auth/login&msg=" . urlencode("Sesion cerrada correctamente"));
        exit;
    }
}

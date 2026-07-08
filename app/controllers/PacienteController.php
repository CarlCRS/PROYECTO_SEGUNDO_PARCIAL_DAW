<?php
require_once __DIR__ . "/../models/Paciente.php";
require_once __DIR__ . "/../models/Usuario.php";

class PacienteController
{
    public function listar()
    {
        $pacientes = Paciente::obtenerTodos();
        return $pacientes;
    }

    public function crear()
    {
        $usuarios = Usuario::obtenerPorRolNoVinculadoPaciente("paciente");
        return ["usuarios" => $usuarios];
    }

    public function guardar()
    {
        $errores = [];

        $nombre = trim($_POST["nombre"] ?? "");
        $cedula = trim($_POST["cedula"] ?? "");
        $telefono = trim($_POST["telefono"] ?? "");
        $fecha_nacimiento = trim($_POST["fecha_nacimiento"] ?? "");
        $usuario_id = !empty($_POST["usuario_id"]) ? intval($_POST["usuario_id"]) : null;

        if ($nombre === "") {
            $errores[] = "El nombre es obligatorio";
        }
        if ($cedula === "") {
            $errores[] = "La cedula es obligatoria";
        } elseif (Paciente::existeCedula($cedula)) {
            $errores[] = "Esa cedula ya esta registrada";
        }

        if (!empty($errores)) {
            $usuarios = Usuario::obtenerPorRolNoVinculadoPaciente("paciente");
            return ["errores" => $errores, "datos" => $_POST, "usuarios" => $usuarios];
        }

        $datos = [
            "usuario_id"       => $usuario_id,
            "nombre"           => htmlspecialchars($nombre),
            "cedula"           => htmlspecialchars($cedula),
            "telefono"         => htmlspecialchars($telefono),
            "fecha_nacimiento" => $fecha_nacimiento,
        ];

        if (Paciente::crear($datos)) {
            header("Location: ?url=pacientes/listar&msg=" . urlencode("Paciente registrado exitosamente"));
            exit;
        }

        $usuarios = Usuario::obtenerPorRolNoVinculadoPaciente("paciente");
        return ["errores" => ["Error al registrar el paciente"], "datos" => $_POST, "usuarios" => $usuarios];
    }

    public function editar($id)
    {
        $paciente = Paciente::obtenerPorId($id);
        if (!$paciente) {
            header("Location: ?url=pacientes/listar&msg=" . urlencode("Paciente no encontrado"));
            exit;
        }
        $usuarios = Usuario::obtenerPorRolNoVinculadoPaciente("paciente");
        if ($paciente["usuario_id"]) {
            $actual = Usuario::obtenerPorId($paciente["usuario_id"]);
            if ($actual) {
                array_unshift($usuarios, $actual);
            }
        }
        $paciente["usuarios"] = $usuarios;
        return $paciente;
    }

    public function actualizar()
    {
        $id = intval($_POST["id"] ?? 0);
        $errores = [];

        $nombre = trim($_POST["nombre"] ?? "");
        $cedula = trim($_POST["cedula"] ?? "");
        $telefono = trim($_POST["telefono"] ?? "");
        $fecha_nacimiento = trim($_POST["fecha_nacimiento"] ?? "");
        $usuario_id = !empty($_POST["usuario_id"]) ? intval($_POST["usuario_id"]) : null;

        if ($id <= 0) {
            $errores[] = "ID de paciente invalido";
        }
        if ($nombre === "") {
            $errores[] = "El nombre es obligatorio";
        }
        if ($cedula === "") {
            $errores[] = "La cedula es obligatoria";
        } elseif (Paciente::existeCedula($cedula, $id)) {
            $errores[] = "Esa cedula ya esta registrada por otro paciente";
        }

        if (!empty($errores)) {
            $usuarios = Usuario::obtenerPorRolNoVinculadoPaciente("paciente");
            return ["errores" => $errores, "datos" => $_POST, "usuarios" => $usuarios];
        }

        $datos = [
            "usuario_id"       => $usuario_id,
            "nombre"           => htmlspecialchars($nombre),
            "cedula"           => htmlspecialchars($cedula),
            "telefono"         => htmlspecialchars($telefono),
            "fecha_nacimiento" => $fecha_nacimiento,
        ];

        if (Paciente::actualizar($id, $datos)) {
            header("Location: ?url=pacientes/listar&msg=" . urlencode("Paciente actualizado exitosamente"));
            exit;
        }

        $usuarios = Usuario::obtenerPorRolNoVinculadoPaciente("paciente");
        return ["errores" => ["Error al actualizar el paciente"], "datos" => $_POST, "usuarios" => $usuarios];
    }

    public function eliminar($id)
    {
        $paciente = Paciente::obtenerPorId($id);
        if (!$paciente) {
            header("Location: ?url=pacientes/listar&msg=" . urlencode("Paciente no encontrado"));
            exit;
        }

        if (Paciente::eliminar($id)) {
            header("Location: ?url=pacientes/listar&msg=" . urlencode("Paciente eliminado exitosamente"));
            exit;
        }

        header("Location: ?url=pacientes/listar&msg=" . urlencode("Error al eliminar el paciente"));
        exit;
    }
}

<?php
require_once __DIR__ . "/../models/Medico.php";
require_once __DIR__ . "/../models/Especialidad.php";

class MedicoController
{
    public function listar()
    {
        $medicos = Medico::obtenerTodos();
        return $medicos;
    }

    public function crear()
    {
        $especialidades = Especialidad::obtenerTodas();
        return ["especialidades" => $especialidades];
    }

    public function guardar()
    {
        $errores = [];

        $nombre = trim($_POST["nombre"] ?? "");
        $especialidad_id = intval($_POST["especialidad_id"] ?? 0);
        $telefono = trim($_POST["telefono"] ?? "");
        $usuario_id = !empty($_POST["usuario_id"]) ? intval($_POST["usuario_id"]) : null;

        if ($nombre === "") {
            $errores[] = "El nombre es obligatorio";
        }
        if ($especialidad_id <= 0) {
            $errores[] = "Seleccione una especialidad";
        }

        if (!empty($errores)) {
            $especialidades = Especialidad::obtenerTodas();
            return ["errores" => $errores, "datos" => $_POST, "especialidades" => $especialidades];
        }

        $datos = [
            "usuario_id"       => $usuario_id,
            "nombre"           => htmlspecialchars($nombre),
            "especialidad_id"  => $especialidad_id,
            "telefono"         => htmlspecialchars($telefono),
        ];

        if (Medico::crear($datos)) {
            header("Location: ?url=medicos/listar&msg=" . urlencode("Medico registrado exitosamente"));
            exit;
        }

        $especialidades = Especialidad::obtenerTodas();
        return ["errores" => ["Error al registrar el medico"], "datos" => $_POST, "especialidades" => $especialidades];
    }

    public function editar($id)
    {
        $medico = Medico::obtenerPorId($id);
        if (!$medico) {
            header("Location: ?url=medicos/listar&msg=" . urlencode("Medico no encontrado"));
            exit;
        }
        $especialidades = Especialidad::obtenerTodas();
        $medico["especialidades"] = $especialidades;
        return $medico;
    }

    public function actualizar()
    {
        $id = intval($_POST["id"] ?? 0);
        $errores = [];

        $nombre = trim($_POST["nombre"] ?? "");
        $especialidad_id = intval($_POST["especialidad_id"] ?? 0);
        $telefono = trim($_POST["telefono"] ?? "");
        $usuario_id = !empty($_POST["usuario_id"]) ? intval($_POST["usuario_id"]) : null;

        if ($id <= 0) {
            $errores[] = "ID de medico invalido";
        }
        if ($nombre === "") {
            $errores[] = "El nombre es obligatorio";
        }
        if ($especialidad_id <= 0) {
            $errores[] = "Seleccione una especialidad";
        }

        if (!empty($errores)) {
            $especialidades = Especialidad::obtenerTodas();
            return ["errores" => $errores, "datos" => $_POST, "especialidades" => $especialidades];
        }

        $datos = [
            "usuario_id"       => $usuario_id,
            "nombre"           => htmlspecialchars($nombre),
            "especialidad_id"  => $especialidad_id,
            "telefono"         => htmlspecialchars($telefono),
        ];

        if (Medico::actualizar($id, $datos)) {
            header("Location: ?url=medicos/listar&msg=" . urlencode("Medico actualizado exitosamente"));
            exit;
        }

        $especialidades = Especialidad::obtenerTodas();
        return ["errores" => ["Error al actualizar el medico"], "datos" => $_POST, "especialidades" => $especialidades];
    }

    public function eliminar($id)
    {
        $medico = Medico::obtenerPorId($id);
        if (!$medico) {
            header("Location: ?url=medicos/listar&msg=" . urlencode("Medico no encontrado"));
            exit;
        }

        if (Medico::tieneCitasActivas($id)) {
            header("Location: ?url=medicos/listar&msg=" . urlencode("No se puede eliminar: el medico tiene citas activas"));
            exit;
        }

        if (Medico::eliminar($id)) {
            header("Location: ?url=medicos/listar&msg=" . urlencode("Medico eliminado exitosamente"));
            exit;
        }

        header("Location: ?url=medicos/listar&msg=" . urlencode("Error al eliminar el medico"));
        exit;
    }
}

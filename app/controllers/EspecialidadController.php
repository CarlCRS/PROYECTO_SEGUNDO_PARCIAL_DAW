<?php
require_once __DIR__ . "/../models/Especialidad.php";

class EspecialidadController
{
    public function listar()
    {
        $especialidades = Especialidad::obtenerTodas();
        return $especialidades;
    }

    public function crear()
    {
        return [];
    }

    public function guardar()
    {
        $errores = [];
        $nombre = trim($_POST["nombre"] ?? "");

        if ($nombre === "") {
            $errores[] = "El nombre de la especialidad es obligatorio";
        }

        if (!empty($errores)) {
            return ["errores" => $errores, "datos" => $_POST];
        }

        $datos = ["nombre" => htmlspecialchars($nombre)];

        if (Especialidad::crear($datos)) {
            header("Location: ?url=especialidades/listar&msg=" . urlencode("Especialidad registrada exitosamente"));
            exit;
        }

        return ["errores" => ["Error al registrar la especialidad"], "datos" => $_POST];
    }

    public function editar($id)
    {
        $especialidad = Especialidad::obtenerPorId($id);
        if (!$especialidad) {
            header("Location: ?url=especialidades/listar&msg=" . urlencode("Especialidad no encontrada"));
            exit;
        }
        return $especialidad;
    }

    public function actualizar()
    {
        $id = intval($_POST["id"] ?? 0);
        $errores = [];
        $nombre = trim($_POST["nombre"] ?? "");

        if ($id <= 0) {
            $errores[] = "ID de especialidad invalido";
        }
        if ($nombre === "") {
            $errores[] = "El nombre de la especialidad es obligatorio";
        }

        if (!empty($errores)) {
            return ["errores" => $errores, "datos" => $_POST];
        }

        $datos = ["nombre" => htmlspecialchars($nombre)];

        if (Especialidad::actualizar($id, $datos)) {
            header("Location: ?url=especialidades/listar&msg=" . urlencode("Especialidad actualizada exitosamente"));
            exit;
        }

        return ["errores" => ["Error al actualizar la especialidad"], "datos" => $_POST];
    }

    public function eliminar($id)
    {
        $especialidad = Especialidad::obtenerPorId($id);
        if (!$especialidad) {
            header("Location: ?url=especialidades/listar&msg=" . urlencode("Especialidad no encontrada"));
            exit;
        }

        if (Especialidad::tieneMedicosAsociados($id)) {
            header("Location: ?url=especialidades/listar&msg=" . urlencode("No se puede eliminar: hay medicos asociados a esta especialidad"));
            exit;
        }

        if (Especialidad::tieneServiciosAsociados($id)) {
            header("Location: ?url=especialidades/listar&msg=" . urlencode("No se puede eliminar: hay servicios asociados a esta especialidad"));
            exit;
        }

        if (Especialidad::eliminar($id)) {
            header("Location: ?url=especialidades/listar&msg=" . urlencode("Especialidad eliminada exitosamente"));
            exit;
        }

        header("Location: ?url=especialidades/listar&msg=" . urlencode("Error al eliminar la especialidad"));
        exit;
    }
}

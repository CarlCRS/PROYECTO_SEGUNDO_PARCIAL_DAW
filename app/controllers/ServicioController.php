<?php
require_once __DIR__ . "/../models/Servicio.php";
require_once __DIR__ . "/../models/Especialidad.php";

class ServicioController
{
    public function listar($especialidadId)
    {
        $servicios = Servicio::obtenerPorEspecialidad($especialidadId);
        return $servicios;
    }

    public function crear()
    {
        $especialidades = Especialidad::obtenerTodas();
        return ["especialidades" => $especialidades];
    }

    public function guardar()
    {
        $errores = [];

        $especialidad_id = intval($_POST["especialidad_id"] ?? 0);
        $nombre = trim($_POST["nombre"] ?? "");
        $tarifa = trim($_POST["tarifa"] ?? "");

        if ($especialidad_id <= 0) {
            $errores[] = "Seleccione una especialidad";
        }
        if ($nombre === "") {
            $errores[] = "El nombre del servicio es obligatorio";
        }
        if ($tarifa === "" || !is_numeric($tarifa) || floatval($tarifa) <= 0) {
            $errores[] = "Ingrese una tarifa valida mayor a cero";
        }

        if (!empty($errores)) {
            $especialidades = Especialidad::obtenerTodas();
            return ["errores" => $errores, "datos" => $_POST, "especialidades" => $especialidades];
        }

        $datos = [
            "especialidad_id" => $especialidad_id,
            "nombre"          => htmlspecialchars($nombre),
            "tarifa"          => floatval($tarifa),
        ];

        if (Servicio::crear($datos)) {
            header("Location: ?url=servicios/listar&especialidad_id=$especialidad_id&msg=" . urlencode("Servicio registrado exitosamente"));
            exit;
        }

        $especialidades = Especialidad::obtenerTodas();
        return ["errores" => ["Error al registrar el servicio"], "datos" => $_POST, "especialidades" => $especialidades];
    }

    public function editar($id)
    {
        $servicio = Servicio::obtenerPorId($id);
        if (!$servicio) {
            header("Location: ?url=especialidades/listar&msg=" . urlencode("Servicio no encontrado"));
            exit;
        }
        $especialidades = Especialidad::obtenerTodas();
        $servicio["especialidades"] = $especialidades;
        return $servicio;
    }

    public function actualizar()
    {
        $id = intval($_POST["id"] ?? 0);
        $errores = [];

        $especialidad_id = intval($_POST["especialidad_id"] ?? 0);
        $nombre = trim($_POST["nombre"] ?? "");
        $tarifa = trim($_POST["tarifa"] ?? "");

        if ($id <= 0) {
            $errores[] = "ID de servicio invalido";
        }
        if ($especialidad_id <= 0) {
            $errores[] = "Seleccione una especialidad";
        }
        if ($nombre === "") {
            $errores[] = "El nombre del servicio es obligatorio";
        }
        if ($tarifa === "" || !is_numeric($tarifa) || floatval($tarifa) <= 0) {
            $errores[] = "Ingrese una tarifa valida mayor a cero";
        }

        if (!empty($errores)) {
            $especialidades = Especialidad::obtenerTodas();
            return ["errores" => $errores, "datos" => $_POST, "especialidades" => $especialidades];
        }

        $datos = [
            "especialidad_id" => $especialidad_id,
            "nombre"          => htmlspecialchars($nombre),
            "tarifa"          => floatval($tarifa),
        ];

        if (Servicio::actualizar($id, $datos)) {
            header("Location: ?url=servicios/listar&especialidad_id=$especialidad_id&msg=" . urlencode("Servicio actualizado exitosamente"));
            exit;
        }

        $especialidades = Especialidad::obtenerTodas();
        return ["errores" => ["Error al actualizar el servicio"], "datos" => $_POST, "especialidades" => $especialidades];
    }

    public function eliminar($id)
    {
        $servicio = Servicio::obtenerPorId($id);
        if (!$servicio) {
            header("Location: ?url=especialidades/listar&msg=" . urlencode("Servicio no encontrado"));
            exit;
        }

        $especialidad_id = $servicio["especialidad_id"];

        if (Servicio::eliminar($id)) {
            header("Location: ?url=servicios/listar&especialidad_id=$especialidad_id&msg=" . urlencode("Servicio eliminado exitosamente"));
            exit;
        }

        header("Location: ?url=servicios/listar&especialidad_id=$especialidad_id&msg=" . urlencode("Error al eliminar el servicio"));
        exit;
    }
}

<?php
require_once __DIR__ . "/../models/Horario.php";
require_once __DIR__ . "/../models/Medico.php";

class HorarioController
{
    public function listar($medicoId)
    {
        $horarios = Horario::obtenerPorMedico($medicoId);
        return $horarios;
    }

    public function crear()
    {
        $medicos = Medico::obtenerTodos();
        return ["medicos" => $medicos];
    }

    public function guardar()
    {
        $errores = [];

        $medico_id = intval($_POST["medico_id"] ?? 0);
        $dia_semana = trim($_POST["dia_semana"] ?? "");
        $hora_inicio = trim($_POST["hora_inicio"] ?? "");
        $hora_fin = trim($_POST["hora_fin"] ?? "");

        if ($medico_id <= 0) {
            $errores[] = "Seleccione un medico";
        }
        if ($dia_semana === "") {
            $errores[] = "Seleccione un dia de la semana";
        }
        if ($hora_inicio === "") {
            $errores[] = "La hora de inicio es obligatoria";
        }
        if ($hora_fin === "") {
            $errores[] = "La hora de fin es obligatoria";
        }
        if ($hora_inicio !== "" && $hora_fin !== "" && $hora_inicio >= $hora_fin) {
            $errores[] = "La hora de fin debe ser posterior a la hora de inicio";
        }

        if (!empty($errores)) {
            $medicos = Medico::obtenerTodos();
            return ["errores" => $errores, "datos" => $_POST, "medicos" => $medicos];
        }

        $datos = [
            "medico_id"   => $medico_id,
            "dia_semana"  => $dia_semana,
            "hora_inicio" => $hora_inicio,
            "hora_fin"    => $hora_fin,
        ];

        if (Horario::crear($datos)) {
            header("Location: ?url=horarios/listar&medico_id=$medico_id&msg=" . urlencode("Horario registrado exitosamente"));
            exit;
        }

        $medicos = Medico::obtenerTodos();
        return ["errores" => ["Error al registrar el horario"], "datos" => $_POST, "medicos" => $medicos];
    }

    public function editar($id)
    {
        $horario = Horario::obtenerPorId($id);
        if (!$horario) {
            header("Location: ?url=medicos/listar&msg=" . urlencode("Horario no encontrado"));
            exit;
        }
        $medicos = Medico::obtenerTodos();
        $horario["medicos"] = $medicos;
        return $horario;
    }

    public function actualizar()
    {
        $id = intval($_POST["id"] ?? 0);
        $errores = [];

        $medico_id = intval($_POST["medico_id"] ?? 0);
        $dia_semana = trim($_POST["dia_semana"] ?? "");
        $hora_inicio = trim($_POST["hora_inicio"] ?? "");
        $hora_fin = trim($_POST["hora_fin"] ?? "");

        if ($id <= 0) {
            $errores[] = "ID de horario invalido";
        }
        if ($medico_id <= 0) {
            $errores[] = "Seleccione un medico";
        }
        if ($dia_semana === "") {
            $errores[] = "Seleccione un dia de la semana";
        }
        if ($hora_inicio === "") {
            $errores[] = "La hora de inicio es obligatoria";
        }
        if ($hora_fin === "") {
            $errores[] = "La hora de fin es obligatoria";
        }
        if ($hora_inicio !== "" && $hora_fin !== "" && $hora_inicio >= $hora_fin) {
            $errores[] = "La hora de fin debe ser posterior a la hora de inicio";
        }

        if (!empty($errores)) {
            $medicos = Medico::obtenerTodos();
            $horario = Horario::obtenerPorId($id);
            return ["errores" => $errores, "datos" => $_POST, "medicos" => $medicos];
        }

        $datos = [
            "medico_id"   => $medico_id,
            "dia_semana"  => $dia_semana,
            "hora_inicio" => $hora_inicio,
            "hora_fin"    => $hora_fin,
        ];

        if (Horario::actualizar($id, $datos)) {
            header("Location: ?url=horarios/listar&medico_id=$medico_id&msg=" . urlencode("Horario actualizado exitosamente"));
            exit;
        }

        $medicos = Medico::obtenerTodos();
        return ["errores" => ["Error al actualizar el horario"], "datos" => $_POST, "medicos" => $medicos];
    }

    public function eliminar($id)
    {
        $horario = Horario::obtenerPorId($id);
        if (!$horario) {
            header("Location: ?url=medicos/listar&msg=" . urlencode("Horario no encontrado"));
            exit;
        }

        $medico_id = $horario["medico_id"];

        if (Horario::eliminar($id)) {
            header("Location: ?url=horarios/listar&medico_id=$medico_id&msg=" . urlencode("Horario eliminado exitosamente"));
            exit;
        }

        header("Location: ?url=horarios/listar&medico_id=$medico_id&msg=" . urlencode("Error al eliminar el horario"));
        exit;
    }
}

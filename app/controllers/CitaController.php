<?php
require_once __DIR__ . "/../models/Cita.php";

class CitaController
{
    public function listar()
    {
        $citas = Cita::obtenerTodas();
        return $citas;
    }

    public function crear()
    {
        $pacientes = Cita::obtenerPacientes();
        $medicos = Cita::obtenerMedicos();
        return ["pacientes" => $pacientes, "medicos" => $medicos];
    }

    public function guardar()
    {
        $errores = [];

        $paciente_id = intval($_POST["paciente_id"] ?? 0);
        $medico_id = intval($_POST["medico_id"] ?? 0);
        $fecha = trim($_POST["fecha"] ?? "");
        $hora = trim($_POST["hora"] ?? "");
        $motivo = trim($_POST["motivo"] ?? "");

        if ($paciente_id <= 0) {
            $errores[] = "Seleccione un paciente";
        }
        if ($medico_id <= 0) {
            $errores[] = "Seleccione un medico";
        }
        if ($fecha === "") {
            $errores[] = "La fecha es obligatoria";
        } elseif (strtotime($fecha) < strtotime(date("Y-m-d"))) {
            $errores[] = "La fecha debe ser hoy o posterior";
        }
        if ($hora === "") {
            $errores[] = "La hora es obligatoria";
        }
        if ($motivo === "") {
            $errores[] = "El motivo de consulta es obligatorio";
        }

        if (!empty($errores)) {
            $pacientes = Cita::obtenerPacientes();
            $medicos = Cita::obtenerMedicos();
            return ["errores" => $errores, "datos" => $_POST, "pacientes" => $pacientes, "medicos" => $medicos];
        }

        if (Cita::existeCruceHorario($medico_id, $fecha, $hora)) {
            $errores[] = "El medico ya tiene una cita agendada en esa fecha y hora";
            $pacientes = Cita::obtenerPacientes();
            $medicos = Cita::obtenerMedicos();
            return ["errores" => $errores, "datos" => $_POST, "pacientes" => $pacientes, "medicos" => $medicos];
        }

        $datos = [
            "paciente_id" => $paciente_id,
            "medico_id"   => $medico_id,
            "fecha"       => $fecha,
            "hora"        => $hora,
            "motivo"      => htmlspecialchars($motivo),
        ];

        if (Cita::crear($datos)) {
            header("Location: ?url=citas/listar&msg=" . urlencode("Cita registrada exitosamente"));
            exit;
        }

        $pacientes = Cita::obtenerPacientes();
        $medicos = Cita::obtenerMedicos();
        return ["errores" => ["Error al registrar la cita"], "datos" => $_POST, "pacientes" => $pacientes, "medicos" => $medicos];
    }

    public function editar($id)
    {
        $cita = Cita::obtenerPorId($id);
        if (!$cita) {
            header("Location: ?url=citas/listar&msg=" . urlencode("Cita no encontrada"));
            exit;
        }
        $pacientes = Cita::obtenerPacientes();
        $medicos = Cita::obtenerMedicos();
        $cita["pacientes"] = $pacientes;
        $cita["medicos"] = $medicos;
        return $cita;
    }

    public function actualizar()
    {
        $id = intval($_POST["id"] ?? 0);
        $errores = [];

        $paciente_id = intval($_POST["paciente_id"] ?? 0);
        $medico_id = intval($_POST["medico_id"] ?? 0);
        $fecha = trim($_POST["fecha"] ?? "");
        $hora = trim($_POST["hora"] ?? "");
        $estado = trim($_POST["estado"] ?? "pendiente");
        $motivo = trim($_POST["motivo"] ?? "");

        if ($id <= 0) {
            $errores[] = "ID de cita invalido";
        }
        if ($paciente_id <= 0) {
            $errores[] = "Seleccione un paciente";
        }
        if ($medico_id <= 0) {
            $errores[] = "Seleccione un medico";
        }
        if ($fecha === "") {
            $errores[] = "La fecha es obligatoria";
        }
        if ($hora === "") {
            $errores[] = "La hora es obligatoria";
        }

        if (!empty($errores)) {
            $pacientes = Cita::obtenerPacientes();
            $medicos = Cita::obtenerMedicos();
            return ["errores" => $errores, "datos" => $_POST, "pacientes" => $pacientes, "medicos" => $medicos];
        }

        if (Cita::existeCruceHorario($medico_id, $fecha, $hora, $id)) {
            $errores[] = "El medico ya tiene una cita agendada en esa fecha y hora";
            $pacientes = Cita::obtenerPacientes();
            $medicos = Cita::obtenerMedicos();
            return ["errores" => $errores, "datos" => $_POST, "pacientes" => $pacientes, "medicos" => $medicos];
        }

        $datos = [
            "paciente_id" => $paciente_id,
            "medico_id"   => $medico_id,
            "fecha"       => $fecha,
            "hora"        => $hora,
            "estado"      => $estado,
            "motivo"      => htmlspecialchars($motivo),
        ];

        if (Cita::actualizar($id, $datos)) {
            header("Location: ?url=citas/listar&msg=" . urlencode("Cita actualizada exitosamente"));
            exit;
        }

        $pacientes = Cita::obtenerPacientes();
        $medicos = Cita::obtenerMedicos();
        return ["errores" => ["Error al actualizar la cita"], "datos" => $_POST, "pacientes" => $pacientes, "medicos" => $medicos];
    }

    public function eliminar($id)
    {
        $cita = Cita::obtenerPorId($id);
        if (!$cita) {
            header("Location: ?url=citas/listar&msg=" . urlencode("Cita no encontrada"));
            exit;
        }

        if (Cita::cancelar($id)) {
            header("Location: ?url=citas/listar&msg=" . urlencode("Cita cancelada exitosamente"));
            exit;
        }

        header("Location: ?url=citas/listar&msg=" . urlencode("Error al cancelar la cita"));
        exit;
    }
}

<?php
require_once __DIR__ . "/../models/Cita.php";
require_once __DIR__ . "/../models/Paciente.php";
require_once __DIR__ . "/../models/Pago.php";

class CitaController
{
    public function listar()
    {
        if ($_SESSION["rol"] === "admin") {
            $citas = Cita::obtenerTodas();
        } else {
            $paciente = Paciente::obtenerPorUsuarioId($_SESSION["id_usuario"]);
            $citas = $paciente ? Cita::obtenerPorPaciente($paciente["id"]) : [];
        }
        return $citas;
    }

    public function listarMedico()
    {
        $medico = Medico::obtenerPorUsuarioId($_SESSION["id_usuario"]);
        if (!$medico) {
            header("Location: ?url=inicio&msg=" . urlencode("No tienes un perfil de medico vinculado"));
            exit;
        }
        return Cita::obtenerPorMedico($medico["id"]);
    }

    public function crear()
    {
        $medicos = Cita::obtenerMedicos();
        $resultado = ["medicos" => $medicos];

        if ($_SESSION["rol"] === "admin") {
            $resultado["pacientes"] = Cita::obtenerPacientes();
        } else {
            $paciente = Paciente::obtenerPorUsuarioId($_SESSION["id_usuario"]);
            $resultado["paciente_id"] = $paciente["id"] ?? 0;
            $resultado["pacientes"] = [];
        }

        return $resultado;
    }

    public function guardar()
    {
        $errores = [];

        $paciente_id = $_SESSION["rol"] === "admin"
            ? intval($_POST["paciente_id"] ?? 0)
            : intval(Paciente::obtenerPorUsuarioId($_SESSION["id_usuario"])["id"] ?? 0);
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
            $medicos = Cita::obtenerMedicos();
            $ret = ["errores" => $errores, "datos" => $_POST, "medicos" => $medicos];
            if ($_SESSION["rol"] === "admin") {
                $ret["pacientes"] = Cita::obtenerPacientes();
            }
            return $ret;
        }

        if (Cita::existeCruceHorario($medico_id, $fecha, $hora)) {
            $errores[] = "El medico ya tiene una cita agendada en esa fecha y hora";
            $medicos = Cita::obtenerMedicos();
            $ret = ["errores" => $errores, "datos" => $_POST, "medicos" => $medicos];
            if ($_SESSION["rol"] === "admin") {
                $ret["pacientes"] = Cita::obtenerPacientes();
            }
            return $ret;
        }

        $datos = [
            "paciente_id" => $paciente_id,
            "medico_id"   => $medico_id,
            "fecha"       => $fecha,
            "hora"        => $hora,
            "motivo"      => htmlspecialchars($motivo),
        ];

        if (Cita::crear($datos) !== false) {
            header("Location: ?url=citas/listar&msg=" . urlencode("Cita registrada exitosamente"));
            exit;
        }

        $medicos = Cita::obtenerMedicos();
        $ret = ["errores" => ["Error al registrar la cita"], "datos" => $_POST, "medicos" => $medicos];
        if ($_SESSION["rol"] === "admin") {
            $ret["pacientes"] = Cita::obtenerPacientes();
        }
        return $ret;
    }

    public function editar($id)
    {
        $cita = Cita::obtenerPorId($id);
        if (!$cita) {
            header("Location: ?url=citas/listar&msg=" . urlencode("Cita no encontrada"));
            exit;
        }
        if ($_SESSION["rol"] !== "admin") {
            $paciente = Paciente::obtenerPorUsuarioId($_SESSION["id_usuario"]);
            if (!$paciente || intval($cita["paciente_id"]) !== intval($paciente["id"])) {
                header("Location: ?url=citas/listar&msg=" . urlencode("No puedes editar citas de otros pacientes"));
                exit;
            }
        }
        $medicos = Cita::obtenerMedicos();
        $cita["medicos"] = $medicos;
        $cita["pacientes"] = $_SESSION["rol"] === "admin" ? Cita::obtenerPacientes() : [];
        return $cita;
    }

    public function actualizar()
    {
        $id = intval($_POST["id"] ?? 0);
        $errores = [];

        $paciente_id = $_SESSION["rol"] === "admin"
            ? intval($_POST["paciente_id"] ?? 0)
            : intval(Paciente::obtenerPorUsuarioId($_SESSION["id_usuario"])["id"] ?? 0);
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
            $medicos = Cita::obtenerMedicos();
            $ret = ["errores" => $errores, "datos" => $_POST, "medicos" => $medicos];
            if ($_SESSION["rol"] === "admin") {
                $ret["pacientes"] = Cita::obtenerPacientes();
            }
            return $ret;
        }

        if (Cita::existeCruceHorario($medico_id, $fecha, $hora, $id)) {
            $errores[] = "El medico ya tiene una cita agendada en esa fecha y hora";
            $medicos = Cita::obtenerMedicos();
            $ret = ["errores" => $errores, "datos" => $_POST, "medicos" => $medicos];
            if ($_SESSION["rol"] === "admin") {
                $ret["pacientes"] = Cita::obtenerPacientes();
            }
            return $ret;
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

        $medicos = Cita::obtenerMedicos();
        $ret = ["errores" => ["Error al actualizar la cita"], "datos" => $_POST, "medicos" => $medicos];
        if ($_SESSION["rol"] === "admin") {
            $ret["pacientes"] = Cita::obtenerPacientes();
        }
        return $ret;
    }

    public function eliminar($id)
    {
        $cita = Cita::obtenerPorId($id);
        if (!$cita) {
            header("Location: ?url=citas/listar&msg=" . urlencode("Cita no encontrada"));
            exit;
        }

        if ($_SESSION["rol"] !== "admin") {
            $paciente = Paciente::obtenerPorUsuarioId($_SESSION["id_usuario"]);
            if (!$paciente || intval($cita["paciente_id"]) !== intval($paciente["id"])) {
                header("Location: ?url=citas/listar&msg=" . urlencode("No puedes cancelar citas de otros pacientes"));
                exit;
            }
        }

        if (Cita::cancelar($id)) {
            Pago::cancelarPorCita($id);
            header("Location: ?url=citas/listar&msg=" . urlencode("Cita cancelada exitosamente"));
            exit;
        }

        header("Location: ?url=citas/listar&msg=" . urlencode("Error al cancelar la cita"));
        exit;
    }
}

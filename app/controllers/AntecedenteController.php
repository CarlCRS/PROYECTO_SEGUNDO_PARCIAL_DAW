<?php
require_once __DIR__ . "/../models/Antecedente.php";
require_once __DIR__ . "/../models/Paciente.php";

class AntecedenteController
{
    public function listar($pacienteId)
    {
        $antecedentes = Antecedente::obtenerPorPaciente($pacienteId);
        return $antecedentes;
    }

    public function crear()
    {
        $pacientes = Paciente::obtenerTodos();
        return ["pacientes" => $pacientes];
    }

    public function guardar()
    {
        $errores = [];

        $paciente_id = intval($_POST["paciente_id"] ?? 0);
        $descripcion = trim($_POST["descripcion"] ?? "");
        $fecha_registro = trim($_POST["fecha_registro"] ?? "");

        if ($paciente_id <= 0) {
            $errores[] = "Seleccione un paciente";
        }
        if ($descripcion === "") {
            $errores[] = "La descripcion es obligatoria";
        }
        if ($fecha_registro === "") {
            $errores[] = "La fecha de registro es obligatoria";
        }

        if (!empty($errores)) {
            $pacientes = Paciente::obtenerTodos();
            return ["errores" => $errores, "datos" => $_POST, "pacientes" => $pacientes];
        }

        $datos = [
            "paciente_id"    => $paciente_id,
            "descripcion"    => htmlspecialchars($descripcion),
            "fecha_registro" => $fecha_registro,
        ];

        if (Antecedente::crear($datos)) {
            header("Location: ?url=antecedentes/listar&paciente_id=$paciente_id&msg=" . urlencode("Antecedente registrado exitosamente"));
            exit;
        }

        $pacientes = Paciente::obtenerTodos();
        return ["errores" => ["Error al registrar el antecedente"], "datos" => $_POST, "pacientes" => $pacientes];
    }

    public function editar($id)
    {
        $antecedente = Antecedente::obtenerPorId($id);
        if (!$antecedente) {
            header("Location: ?url=pacientes/listar&msg=" . urlencode("Antecedente no encontrado"));
            exit;
        }
        $pacientes = Paciente::obtenerTodos();
        $antecedente["pacientes"] = $pacientes;
        return $antecedente;
    }

    public function actualizar()
    {
        $id = intval($_POST["id"] ?? 0);
        $errores = [];

        $paciente_id = intval($_POST["paciente_id"] ?? 0);
        $descripcion = trim($_POST["descripcion"] ?? "");
        $fecha_registro = trim($_POST["fecha_registro"] ?? "");

        if ($id <= 0) {
            $errores[] = "ID de antecedente invalido";
        }
        if ($paciente_id <= 0) {
            $errores[] = "Seleccione un paciente";
        }
        if ($descripcion === "") {
            $errores[] = "La descripcion es obligatoria";
        }
        if ($fecha_registro === "") {
            $errores[] = "La fecha de registro es obligatoria";
        }

        if (!empty($errores)) {
            $antecedente = Antecedente::obtenerPorId($id);
            $pacientes = Paciente::obtenerTodos();
            return ["errores" => $errores, "datos" => $_POST, "pacientes" => $pacientes];
        }

        $datos = [
            "paciente_id"    => $paciente_id,
            "descripcion"    => htmlspecialchars($descripcion),
            "fecha_registro" => $fecha_registro,
        ];

        if (Antecedente::actualizar($id, $datos)) {
            header("Location: ?url=antecedentes/listar&paciente_id=$paciente_id&msg=" . urlencode("Antecedente actualizado exitosamente"));
            exit;
        }

        $antecedente = Antecedente::obtenerPorId($id);
        $pacientes = Paciente::obtenerTodos();
        return ["errores" => ["Error al actualizar el antecedente"], "datos" => $_POST, "pacientes" => $pacientes];
    }

    public function eliminar($id)
    {
        $antecedente = Antecedente::obtenerPorId($id);
        if (!$antecedente) {
            header("Location: ?url=pacientes/listar&msg=" . urlencode("Antecedente no encontrado"));
            exit;
        }

        $paciente_id = $antecedente["paciente_id"];

        if (Antecedente::eliminar($id)) {
            header("Location: ?url=antecedentes/listar&paciente_id=$paciente_id&msg=" . urlencode("Antecedente eliminado exitosamente"));
            exit;
        }

        header("Location: ?url=antecedentes/listar&paciente_id=$paciente_id&msg=" . urlencode("Error al eliminar el antecedente"));
        exit;
    }
}

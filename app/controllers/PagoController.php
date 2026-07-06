<?php
require_once __DIR__ . "/../models/Pago.php";
require_once __DIR__ . "/../models/Cita.php";

class PagoController
{
    public function listar($citaId)
    {
        $pagos = Pago::obtenerPorCita($citaId);
        return $pagos;
    }

    public function crear()
    {
        $citas = Cita::obtenerTodas();
        return ["citas" => $citas];
    }

    public function guardar()
    {
        $errores = [];

        $cita_id = intval($_POST["cita_id"] ?? 0);
        $monto = trim($_POST["monto"] ?? "");
        $metodo_pago = trim($_POST["metodo_pago"] ?? "");
        $fecha_pago = trim($_POST["fecha_pago"] ?? "");

        if ($cita_id <= 0) {
            $errores[] = "Seleccione una cita";
        }
        if ($monto === "" || !is_numeric($monto) || floatval($monto) <= 0) {
            $errores[] = "Ingrese un monto valido mayor a cero";
        }
        if ($metodo_pago === "") {
            $errores[] = "Seleccione un metodo de pago";
        }
        if ($fecha_pago === "") {
            $errores[] = "La fecha de pago es obligatoria";
        }

        if (!empty($errores)) {
            $citas = Cita::obtenerTodas();
            return ["errores" => $errores, "datos" => $_POST, "citas" => $citas];
        }

        $datos = [
            "cita_id"     => $cita_id,
            "monto"       => floatval($monto),
            "metodo_pago" => $metodo_pago,
            "fecha_pago"  => $fecha_pago,
        ];

        if (Pago::crear($datos)) {
            header("Location: ?url=pagos/listar&cita_id=$cita_id&msg=" . urlencode("Pago registrado exitosamente"));
            exit;
        }

        $citas = Cita::obtenerTodas();
        return ["errores" => ["Error al registrar el pago"], "datos" => $_POST, "citas" => $citas];
    }

    public function editar($id)
    {
        $pago = Pago::obtenerPorId($id);
        if (!$pago) {
            header("Location: ?url=citas/listar&msg=" . urlencode("Pago no encontrado"));
            exit;
        }
        $citas = Cita::obtenerTodas();
        $pago["citas"] = $citas;
        return $pago;
    }

    public function actualizar()
    {
        $id = intval($_POST["id"] ?? 0);
        $errores = [];

        $cita_id = intval($_POST["cita_id"] ?? 0);
        $monto = trim($_POST["monto"] ?? "");
        $metodo_pago = trim($_POST["metodo_pago"] ?? "");
        $fecha_pago = trim($_POST["fecha_pago"] ?? "");

        if ($id <= 0) {
            $errores[] = "ID de pago invalido";
        }
        if ($cita_id <= 0) {
            $errores[] = "Seleccione una cita";
        }
        if ($monto === "" || !is_numeric($monto) || floatval($monto) <= 0) {
            $errores[] = "Ingrese un monto valido mayor a cero";
        }
        if ($metodo_pago === "") {
            $errores[] = "Seleccione un metodo de pago";
        }
        if ($fecha_pago === "") {
            $errores[] = "La fecha de pago es obligatoria";
        }

        if (!empty($errores)) {
            $citas = Cita::obtenerTodas();
            return ["errores" => $errores, "datos" => $_POST, "citas" => $citas];
        }

        $datos = [
            "cita_id"     => $cita_id,
            "monto"       => floatval($monto),
            "metodo_pago" => $metodo_pago,
            "fecha_pago"  => $fecha_pago,
        ];

        if (Pago::actualizar($id, $datos)) {
            header("Location: ?url=pagos/listar&cita_id=$cita_id&msg=" . urlencode("Pago actualizado exitosamente"));
            exit;
        }

        $citas = Cita::obtenerTodas();
        return ["errores" => ["Error al actualizar el pago"], "datos" => $_POST, "citas" => $citas];
    }

    public function eliminar($id)
    {
        $pago = Pago::obtenerPorId($id);
        if (!$pago) {
            header("Location: ?url=citas/listar&msg=" . urlencode("Pago no encontrado"));
            exit;
        }

        $cita_id = $pago["cita_id"];

        if (Pago::eliminar($id)) {
            header("Location: ?url=pagos/listar&cita_id=$cita_id&msg=" . urlencode("Pago eliminado exitosamente"));
            exit;
        }

        header("Location: ?url=pagos/listar&cita_id=$cita_id&msg=" . urlencode("Error al eliminar el pago"));
        exit;
    }
}

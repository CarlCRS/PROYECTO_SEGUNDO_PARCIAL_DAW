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

    public function editar($id)
    {
        $pago = Pago::obtenerPorId($id);
        if (!$pago) {
            header("Location: ?url=citas/listar&msg=" . urlencode("Pago no encontrado"));
            exit;
        }
        return $pago;
    }

    public function actualizar()
    {
        $id = intval($_POST["id"] ?? 0);
        $errores = [];

        $monto = trim($_POST["monto"] ?? "");
        $metodo_pago = trim($_POST["metodo_pago"] ?? "");
        $estado_pago = trim($_POST["estado_pago"] ?? "");
        $fecha_pago = trim($_POST["fecha_pago"] ?? "");

        if ($id <= 0) {
            $errores[] = "ID de pago invalido";
        }
        if ($monto === "" || !is_numeric($monto) || floatval($monto) <= 0) {
            $errores[] = "Ingrese un monto valido mayor a cero";
        }
        if ($metodo_pago === "" || $metodo_pago === "pendiente") {
            $errores[] = "Seleccione un metodo de pago real (efectivo, tarjeta, transferencia)";
        }
        if (!in_array($estado_pago, ["pendiente", "pagado", "cancelado", "reembolsado"])) {
            $errores[] = "Seleccione un estado de pago valido";
        }
        if ($fecha_pago === "") {
            $errores[] = "La fecha de pago es obligatoria";
        }

        if (!empty($errores)) {
            return ["errores" => $errores, "datos" => $_POST];
        }

        $pagoExiste = Pago::obtenerPorId($id);
        if (!$pagoExiste) {
            header("Location: ?url=citas/listar&msg=" . urlencode("Pago no encontrado"));
            exit;
        }

        $datos = [
            "monto"       => floatval($monto),
            "estado_pago" => $estado_pago,
            "metodo_pago" => $metodo_pago,
            "fecha_pago"  => $fecha_pago,
        ];

        if (Pago::actualizar($id, $datos)) {
            $cita_id = $pagoExiste["cita_id"];
            header("Location: ?url=pagos/listar&cita_id=$cita_id&msg=" . urlencode("Pago actualizado exitosamente"));
            exit;
        }

        return ["errores" => ["Error al actualizar el pago"], "datos" => $_POST];
    }
}
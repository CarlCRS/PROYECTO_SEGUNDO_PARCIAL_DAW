<?php $titulo = "Editar pago"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1>Editar pago</h1>
    </div>

    <?php if (!empty($errores)): ?>
        <div class="msg msg-error">
            <ul style="margin-left:18px">
                <?php foreach ($errores as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="?url=pagos/actualizar">
        <input type="hidden" name="id" value="<?= htmlspecialchars($pago["id"]) ?>">

        <label>Monto ($)</label>
        <input type="number" name="monto" value="<?= htmlspecialchars($datos["monto"] ?? $pago["monto"] ?? "") ?>" step="0.01" min="0.01" required>

        <label>Estado del pago</label>
        <select name="estado_pago" required>
            <option value="">Seleccione un estado</option>
            <option value="pendiente" <?= (($datos["estado_pago"] ?? $pago["estado_pago"] ?? "") === "pendiente") ? "selected" : "" ?>>Pendiente</option>
            <option value="pagado" <?= (($datos["estado_pago"] ?? $pago["estado_pago"] ?? "") === "pagado") ? "selected" : "" ?>>Pagado</option>
            <option value="cancelado" <?= (($datos["estado_pago"] ?? $pago["estado_pago"] ?? "") === "cancelado") ? "selected" : "" ?>>Cancelado</option>
            <option value="reembolsado" <?= (($datos["estado_pago"] ?? $pago["estado_pago"] ?? "") === "reembolsado") ? "selected" : "" ?>>Reembolsado</option>
        </select>

        <label>Metodo de pago</label>
        <select name="metodo_pago" required>
            <option value="">Seleccione un metodo</option>
            <option value="efectivo" <?= (($datos["metodo_pago"] ?? $pago["metodo_pago"] ?? "") === "efectivo") ? "selected" : "" ?>>Efectivo</option>
            <option value="tarjeta" <?= (($datos["metodo_pago"] ?? $pago["metodo_pago"] ?? "") === "tarjeta") ? "selected" : "" ?>>Tarjeta</option>
            <option value="transferencia" <?= (($datos["metodo_pago"] ?? $pago["metodo_pago"] ?? "") === "transferencia") ? "selected" : "" ?>>Transferencia</option>
        </select>

        <label>Fecha de pago</label>
        <input type="date" name="fecha_pago" value="<?= htmlspecialchars($datos["fecha_pago"] ?? $pago["fecha_pago"] ?? date("Y-m-d")) ?>" required>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="?url=pagos/listar&cita_id=<?= $pago["cita_id"] ?? 0 ?>" class="btn btn-ghost">Volver</a>
        </div>
    </form>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>
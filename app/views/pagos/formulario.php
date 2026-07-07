<?php $titulo = $esEdicion ? "Editar pago" : "Nuevo pago"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1><?= $esEdicion ? "Editar pago" : "Nuevo pago" ?></h1>
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

    <form method="POST" action="?url=pagos/<?= $esEdicion ? "actualizar" : "guardar" ?>">

        <?php if ($esEdicion): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($pago["id"]) ?>">
        <?php endif; ?>

        <label>Cita</label>
        <select name="cita_id" required>
            <option value="">Seleccione una cita</option>
            <?php foreach ($listaCitas as $c): ?>
                <option value="<?= $c["id"] ?>" <?= (intval($datos["cita_id"] ?? 0) === intval($c["id"])) ? "selected" : "" ?>>
                    #<?= $c["id"] ?> — <?= htmlspecialchars($c["paciente_nombre"]) ?> con <?= htmlspecialchars($c["medico_nombre"]) ?> (<?= htmlspecialchars($c["fecha"]) ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label>Monto ($)</label>
        <input type="number" name="monto" value="<?= htmlspecialchars($datos["monto"] ?? "") ?>" step="0.01" min="0.01" required>

        <label>Metodo de pago</label>
        <select name="metodo_pago" required>
            <option value="">Seleccione un metodo</option>
            <option value="efectivo" <?= ($datos["metodo_pago"] ?? "") === "efectivo" ? "selected" : "" ?>>Efectivo</option>
            <option value="tarjeta" <?= ($datos["metodo_pago"] ?? "") === "tarjeta" ? "selected" : "" ?>>Tarjeta</option>
            <option value="transferencia" <?= ($datos["metodo_pago"] ?? "") === "transferencia" ? "selected" : "" ?>>Transferencia</option>
        </select>

        <label>Fecha de pago</label>
        <input type="date" name="fecha_pago" value="<?= htmlspecialchars($datos["fecha_pago"] ?? date("Y-m-d")) ?>" required>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $esEdicion ? "Actualizar" : "Guardar" ?></button>
            <a href="?url=pagos/listar&cita_id=<?= $datos["cita_id"] ?? 0 ?>" class="btn btn-ghost">Volver</a>
        </div>

    </form>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

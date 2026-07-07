<?php $titulo = $esEdicion ? "Editar cita" : "Nueva cita"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1><?= $esEdicion ? "Editar cita" : "Nueva cita" ?></h1>
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

    <form method="POST" action="?url=citas/<?= $esEdicion ? "actualizar" : "guardar" ?>">

        <?php if ($esEdicion): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($cita["id"]) ?>">
        <?php endif; ?>

        <label>Paciente</label>
        <select name="paciente_id" required>
            <option value="">Seleccione un paciente</option>
            <?php foreach ($listaPacientes as $p): ?>
                <option value="<?= $p["id"] ?>" <?= (intval($datos["paciente_id"] ?? 0) === intval($p["id"])) ? "selected" : "" ?>>
                    <?= htmlspecialchars($p["nombre"]) ?> (<?= htmlspecialchars($p["cedula"]) ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label>Medico</label>
        <select name="medico_id" required>
            <option value="">Seleccione un medico</option>
            <?php foreach ($listaMedicos as $m): ?>
                <option value="<?= $m["id"] ?>" <?= (intval($datos["medico_id"] ?? 0) === intval($m["id"])) ? "selected" : "" ?>>
                    <?= htmlspecialchars($m["nombre"]) ?> <?= !empty($m["especialidad_nombre"]) ? "(" . htmlspecialchars($m["especialidad_nombre"]) . ")" : "" ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Fecha</label>
        <input type="date" name="fecha" value="<?= htmlspecialchars($datos["fecha"] ?? "") ?>" required>

        <label>Hora</label>
        <input type="time" name="hora" value="<?= htmlspecialchars($datos["hora"] ?? "") ?>" required>

        <?php if ($esEdicion): ?>
            <label>Estado</label>
            <select name="estado">
                <option value="pendiente" <?= ($datos["estado"] ?? "") === "pendiente" ? "selected" : "" ?>>Pendiente</option>
                <option value="confirmada" <?= ($datos["estado"] ?? "") === "confirmada" ? "selected" : "" ?>>Confirmada</option>
                <option value="cancelada" <?= ($datos["estado"] ?? "") === "cancelada" ? "selected" : "" ?>>Cancelada</option>
                <option value="atendida" <?= ($datos["estado"] ?? "") === "atendida" ? "selected" : "" ?>>Atendida</option>
            </select>
        <?php endif; ?>

        <label>Motivo de consulta</label>
        <textarea name="motivo" rows="3" required><?= htmlspecialchars($datos["motivo"] ?? "") ?></textarea>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $esEdicion ? "Actualizar" : "Guardar" ?></button>
            <a href="?url=citas/listar" class="btn btn-ghost">Volver</a>
        </div>

    </form>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

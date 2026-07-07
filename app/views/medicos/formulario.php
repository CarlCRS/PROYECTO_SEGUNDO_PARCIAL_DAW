<?php $titulo = $esEdicion ? "Editar medico" : "Nuevo medico"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1><?= $esEdicion ? "Editar medico" : "Nuevo medico" ?></h1>
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

    <form method="POST" action="?url=medicos/<?= $esEdicion ? "actualizar" : "guardar" ?>">

        <?php if ($esEdicion): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($medico["id"]) ?>">
        <?php endif; ?>

        <label>Nombre completo</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($datos["nombre"] ?? "") ?>" required>

        <label>Especialidad</label>
        <select name="especialidad_id" required>
            <option value="">Seleccione una especialidad</option>
            <?php foreach ($listaEspecialidades as $e): ?>
                <option value="<?= $e["id"] ?>" <?= (intval($datos["especialidad_id"] ?? 0) === intval($e["id"])) ? "selected" : "" ?>>
                    <?= htmlspecialchars($e["nombre"]) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Telefono</label>
        <input type="text" name="telefono" value="<?= htmlspecialchars($datos["telefono"] ?? "") ?>" pattern="[0-9]+" title="Solo digitos">

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $esEdicion ? "Actualizar" : "Guardar" ?></button>
            <a href="?url=medicos/listar" class="btn btn-ghost">Volver</a>
        </div>

    </form>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

<?php $titulo = $esEdicion ? "Editar servicio" : "Nuevo servicio"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1><?= $esEdicion ? "Editar servicio" : "Nuevo servicio" ?></h1>
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

    <form method="POST" action="?url=servicios/<?= $esEdicion ? "actualizar" : "guardar" ?>">

        <?php if ($esEdicion): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($servicio["id"]) ?>">
        <?php endif; ?>

        <label>Especialidad</label>
        <select name="especialidad_id" required>
            <option value="">Seleccione una especialidad</option>
            <?php foreach ($listaEspecialidades as $e): ?>
                <option value="<?= $e["id"] ?>" <?= (intval($datos["especialidad_id"] ?? 0) === intval($e["id"])) ? "selected" : "" ?>>
                    <?= htmlspecialchars($e["nombre"]) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Nombre del servicio</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($datos["nombre"] ?? "") ?>" required>

        <label>Tarifa ($)</label>
        <input type="number" name="tarifa" value="<?= htmlspecialchars($datos["tarifa"] ?? "") ?>" step="0.01" min="0.01" required>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $esEdicion ? "Actualizar" : "Guardar" ?></button>
            <a href="?url=servicios/listar&especialidad_id=<?= $datos["especialidad_id"] ?? 0 ?>" class="btn btn-ghost">Volver</a>
        </div>

    </form>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

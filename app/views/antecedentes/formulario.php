<?php $titulo = $esEdicion ? "Editar antecedente" : "Nuevo antecedente"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1><?= $esEdicion ? "Editar antecedente" : "Nuevo antecedente" ?></h1>
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

    <form method="POST" action="?url=antecedentes/<?= $esEdicion ? "actualizar" : "guardar" ?>">

        <?php if ($esEdicion): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($antecedente["id"]) ?>">
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

        <label>Descripcion</label>
        <textarea name="descripcion" rows="4" required><?= htmlspecialchars($datos["descripcion"] ?? "") ?></textarea>

        <label>Fecha de registro</label>
        <input type="date" name="fecha_registro" value="<?= htmlspecialchars($datos["fecha_registro"] ?? date("Y-m-d")) ?>" required>

        <br><br>
        <button type="submit" class="btn btn-primary"><?= $esEdicion ? "Actualizar" : "Guardar" ?></button>
        <a href="?url=antecedentes/listar&paciente_id=<?= $datos["paciente_id"] ?? 0 ?>" class="btn btn-secondary">Volver</a>

    </form>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

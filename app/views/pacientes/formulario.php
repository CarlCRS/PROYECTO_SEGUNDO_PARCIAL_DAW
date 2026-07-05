<?php $titulo = $esEdicion ? "Editar paciente" : "Nuevo paciente"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1><?= $esEdicion ? "Editar paciente" : "Nuevo paciente" ?></h1>
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

    <form method="POST" action="?url=pacientes/<?= $esEdicion ? "actualizar" : "guardar" ?>">

        <?php if ($esEdicion): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($paciente["id"]) ?>">
        <?php endif; ?>

        <label>Nombre completo</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($datos["nombre"] ?? "") ?>" required>

        <label>Cedula</label>
        <input type="text" name="cedula" value="<?= htmlspecialchars($datos["cedula"] ?? "") ?>" pattern="[0-9]+" title="Solo digitos" required>

        <label>Telefono</label>
        <input type="text" name="telefono" value="<?= htmlspecialchars($datos["telefono"] ?? "") ?>" pattern="[0-9]+" title="Solo digitos">

        <label>Fecha de nacimiento</label>
        <input type="date" name="fecha_nacimiento" value="<?= htmlspecialchars($datos["fecha_nacimiento"] ?? "") ?>">

        <br><br>
        <button type="submit" class="btn btn-primary"><?= $esEdicion ? "Actualizar" : "Guardar" ?></button>
        <a href="?url=pacientes/listar" class="btn btn-secondary">Volver</a>

    </form>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

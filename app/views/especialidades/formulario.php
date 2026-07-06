<?php $titulo = $esEdicion ? "Editar especialidad" : "Nueva especialidad"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1><?= $esEdicion ? "Editar especialidad" : "Nueva especialidad" ?></h1>
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

    <form method="POST" action="?url=especialidades/<?= $esEdicion ? "actualizar" : "guardar" ?>">

        <?php if ($esEdicion): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($especialidad["id"]) ?>">
        <?php endif; ?>

        <label>Nombre de la especialidad</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($datos["nombre"] ?? "") ?>" required>

        <br><br>
        <button type="submit" class="btn btn-primary"><?= $esEdicion ? "Actualizar" : "Guardar" ?></button>
        <a href="?url=especialidades/listar" class="btn btn-secondary">Volver</a>

    </form>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

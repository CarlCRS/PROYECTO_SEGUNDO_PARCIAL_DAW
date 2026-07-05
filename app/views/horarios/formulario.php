<?php $titulo = $esEdicion ? "Editar horario" : "Nuevo horario"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1><?= $esEdicion ? "Editar horario" : "Nuevo horario" ?></h1>
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

    <form method="POST" action="?url=horarios/<?= $esEdicion ? "actualizar" : "guardar" ?>">

        <?php if ($esEdicion): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($horario["id"]) ?>">
        <?php endif; ?>

        <label>Medico</label>
        <select name="medico_id" required>
            <option value="">Seleccione un medico</option>
            <?php foreach ($listaMedicos as $m): ?>
                <option value="<?= $m["id"] ?>" <?= (intval($datos["medico_id"] ?? 0) === intval($m["id"])) ? "selected" : "" ?>>
                    <?= htmlspecialchars($m["nombre"]) ?> (<?= htmlspecialchars($m["especialidad_nombre"] ?? "Sin esp.") ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label>Dia de la semana</label>
        <select name="dia_semana" required>
            <option value="">Seleccione un dia</option>
            <?php
            $dias = ["lunes", "martes", "miercoles", "jueves", "viernes", "sabado"];
            foreach ($dias as $d):
            ?>
                <option value="<?= $d ?>" <?= ($datos["dia_semana"] ?? "") === $d ? "selected" : "" ?>>
                    <?= ucfirst($d) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Hora de inicio</label>
        <input type="time" name="hora_inicio" value="<?= htmlspecialchars($datos["hora_inicio"] ?? "") ?>" required>

        <label>Hora de fin</label>
        <input type="time" name="hora_fin" value="<?= htmlspecialchars($datos["hora_fin"] ?? "") ?>" required>

        <br><br>
        <button type="submit" class="btn btn-primary"><?= $esEdicion ? "Actualizar" : "Guardar" ?></button>
        <a href="?url=horarios/listar&medico_id=<?= $datos["medico_id"] ?? 0 ?>" class="btn btn-secondary">Volver</a>

    </form>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

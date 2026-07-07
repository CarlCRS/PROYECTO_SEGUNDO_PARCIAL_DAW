<?php $titulo = "Horarios - Sistema de Citas Medicas"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1>Horarios de <?= htmlspecialchars($medico_nombre) ?></h1>
        <a href="?url=horarios/crear&medico_id=<?= $medico_id ?>" class="btn btn-success">+ Nuevo horario</a>
    </div>

    <?php if (isset($_GET["msg"]) && $_GET["msg"] !== ""): ?>
        <div class="msg msg-exito"><?= htmlspecialchars($_GET["msg"]) ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Dia</th>
                    <th>Hora inicio</th>
                    <th>Hora fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($horarios)): ?>
                    <?php foreach ($horarios as $h): ?>
                        <tr>
                            <td><?= htmlspecialchars($h["id"]) ?></td>
                            <td><strong><?= ucfirst(htmlspecialchars($h["dia_semana"])) ?></strong></td>
                            <td><?= htmlspecialchars($h["hora_inicio"]) ?></td>
                            <td><?= htmlspecialchars($h["hora_fin"]) ?></td>
                            <td>
                                <div class="acciones">
                                    <a href="?url=horarios/editar&id=<?= $h["id"] ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="?url=horarios/eliminar&id=<?= $h["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este horario?')">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="empty-table">No hay horarios registrados para este medico</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="?url=medicos/listar" class="btn btn-ghost" style="margin-top:16px">Volver a medicos</a>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

<?php $titulo = "Citas - Sistema de Citas Medicas"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1>Citas registradas</h1>
        <a href="?url=citas/crear" class="btn btn-success">+ Nueva cita</a>
    </div>

    <?php if (isset($_GET["msg"]) && $_GET["msg"] !== ""): ?>
        <div class="msg msg-exito"><?= htmlspecialchars($_GET["msg"]) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Medico</th>
                <th>Especialidad</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th>Motivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($citas)): ?>
                <?php foreach ($citas as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c["id"]) ?></td>
                        <td><strong><?= htmlspecialchars($c["paciente_nombre"]) ?></strong></td>
                        <td><?= htmlspecialchars($c["medico_nombre"]) ?></td>
                        <td><?= htmlspecialchars($c["especialidad_nombre"] ?? "") ?></td>
                        <td><?= htmlspecialchars($c["fecha"]) ?></td>
                        <td><?= htmlspecialchars($c["hora"]) ?></td>
                        <td>
                            <span class="estado estado-<?= htmlspecialchars($c["estado"]) ?>">
                                <?= ucfirst(htmlspecialchars($c["estado"])) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($c["motivo"] ?? "") ?></td>
                        <td>
                            <div class="acciones">
                                <a href="?url=pagos/listar&cita_id=<?= $c["id"] ?>" class="btn btn-primary btn-sm">Pagos</a>
                                <?php if ($c["estado"] !== "cancelada" && $c["estado"] !== "atendida"): ?>
                                    <a href="?url=citas/editar&id=<?= $c["id"] ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="?url=citas/eliminar&id=<?= $c["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Cancelar esta cita?')">Cancelar</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" style="text-align:center;padding:30px;color:#999">No hay citas registradas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

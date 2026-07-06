<?php $titulo = "Pagos - Sistema de Citas Medicas"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1>Pagos de cita #<?= htmlspecialchars($cita_id) ?></h1>
        <a href="?url=pagos/crear&cita_id=<?= $cita_id ?>" class="btn btn-success">+ Nuevo pago</a>
    </div>

    <?php if (isset($_GET["msg"]) && $_GET["msg"] !== ""): ?>
        <div class="msg msg-exito"><?= htmlspecialchars($_GET["msg"]) ?></div>
    <?php endif; ?>

    <?php if (!empty($cita_info)): ?>
        <div style="margin-bottom:15px;padding:10px;background:#f8f9fa;border-radius:6px;">
            <strong>Paciente:</strong> <?= htmlspecialchars($cita_info["paciente_nombre"]) ?> |
            <strong>Medico:</strong> <?= htmlspecialchars($cita_info["medico_nombre"]) ?> |
            <strong>Fecha:</strong> <?= htmlspecialchars($cita_info["fecha"]) ?> <?= htmlspecialchars($cita_info["hora"]) ?>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Monto</th>
                <th>Metodo de pago</th>
                <th>Fecha de pago</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pagos)): ?>
                <?php foreach ($pagos as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p["id"]) ?></td>
                        <td><strong>$ <?= number_format(floatval($p["monto"]), 2) ?></strong></td>
                        <td><?= ucfirst(htmlspecialchars($p["metodo_pago"])) ?></td>
                        <td><?= htmlspecialchars($p["fecha_pago"]) ?></td>
                        <td>
                            <div class="acciones">
                                <a href="?url=pagos/editar&id=<?= $p["id"] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="?url=pagos/eliminar&id=<?= $p["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este pago?')">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center;padding:30px;color:#999">No hay pagos registrados para esta cita</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="?url=citas/listar" class="btn btn-secondary">Volver a citas</a>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

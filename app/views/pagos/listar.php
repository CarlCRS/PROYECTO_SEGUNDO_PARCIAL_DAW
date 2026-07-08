<?php $titulo = "Pagos - Sistema de Citas Medicas"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1>Pagos de cita #<?= htmlspecialchars($cita_id) ?></h1>
    </div>

    <?php if (isset($_GET["msg"]) && $_GET["msg"] !== ""): ?>
        <div class="msg msg-exito"><?= htmlspecialchars($_GET["msg"]) ?></div>
    <?php endif; ?>

    <?php if (!empty($cita_info)): ?>
        <div style="margin-bottom:16px;padding:12px 16px;background:var(--color-surface-hover);border:1px solid var(--color-border-light);border-radius:var(--radius-sm);font-size:0.875rem;color:var(--color-text-secondary);display:flex;gap:16px;flex-wrap:wrap;">
            <span><strong>Paciente:</strong> <?= htmlspecialchars($cita_info["paciente_nombre"]) ?></span>
            <span><strong>Medico:</strong> <?= htmlspecialchars($cita_info["medico_nombre"]) ?></span>
            <span><strong>Fecha:</strong> <?= htmlspecialchars($cita_info["fecha"]) ?> <?= htmlspecialchars($cita_info["hora"]) ?></span>
            <span><strong>Estado cita:</strong>
                <span class="estado estado-<?= htmlspecialchars($cita_info["estado"]) ?>">
                    <?= ucfirst(htmlspecialchars($cita_info["estado"])) ?>
                </span>
            </span>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Monto</th>
                    <th>Estado</th>
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
                            <td>
                                <span class="estado estado-<?= htmlspecialchars($p["estado_pago"]) ?>">
                                    <?= ucfirst(htmlspecialchars($p["estado_pago"])) ?>
                                </span>
                            </td>
                            <td><?= ucfirst(htmlspecialchars($p["metodo_pago"])) ?></td>
                            <td><?= htmlspecialchars($p["fecha_pago"]) ?></td>
                            <td>
                                <div class="acciones">
                                    <?php if ($_SESSION["rol"] === "admin"): ?>
                                    <a href="?url=pagos/editar&id=<?= $p["id"] ?>" class="btn btn-ghost btn-sm">Editar</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="empty-table">No hay pagos registrados para esta cita</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="?url=citas/listar" class="btn btn-ghost" style="margin-top:16px">Volver a citas</a>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>
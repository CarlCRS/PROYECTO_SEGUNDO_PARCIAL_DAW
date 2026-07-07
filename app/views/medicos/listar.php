<?php $titulo = "Medicos - Sistema de Citas Medicas"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1>Medicos registrados</h1>
        <a href="?url=medicos/crear" class="btn btn-success">+ Nuevo medico</a>
    </div>

    <?php if (isset($_GET["msg"]) && $_GET["msg"] !== ""): ?>
        <div class="msg msg-exito"><?= htmlspecialchars($_GET["msg"]) ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Especialidad</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($medicos)): ?>
                    <?php foreach ($medicos as $m): ?>
                        <tr>
                            <td><?= htmlspecialchars($m["id"]) ?></td>
                            <td><strong><?= htmlspecialchars($m["nombre"]) ?></strong></td>
                            <td><?= htmlspecialchars($m["especialidad_nombre"] ?? "Sin asignar") ?></td>
                            <td><?= htmlspecialchars($m["telefono"] ?? "") ?></td>
                            <td>
                                <div class="acciones">
                                    <a href="?url=horarios/listar&medico_id=<?= $m["id"] ?>" class="btn btn-primary btn-sm">Horarios</a>
                                    <a href="?url=medicos/editar&id=<?= $m["id"] ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="?url=medicos/eliminar&id=<?= $m["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este medico?')">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="empty-table">No hay medicos registrados</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

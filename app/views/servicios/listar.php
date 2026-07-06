<?php $titulo = "Servicios - Sistema de Citas Medicas"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1>Servicios de <?= htmlspecialchars($especialidad_nombre) ?></h1>
        <a href="?url=servicios/crear&especialidad_id=<?= $especialidad_id ?>" class="btn btn-success">+ Nuevo servicio</a>
    </div>

    <?php if (isset($_GET["msg"]) && $_GET["msg"] !== ""): ?>
        <div class="msg msg-exito"><?= htmlspecialchars($_GET["msg"]) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tarifa</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($servicios)): ?>
                <?php foreach ($servicios as $s): ?>
                    <tr>
                        <td><?= htmlspecialchars($s["id"]) ?></td>
                        <td><strong><?= htmlspecialchars($s["nombre"]) ?></strong></td>
                        <td>$ <?= number_format(floatval($s["tarifa"]), 2) ?></td>
                        <td>
                            <div class="acciones">
                                <a href="?url=servicios/editar&id=<?= $s["id"] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="?url=servicios/eliminar&id=<?= $s["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este servicio?')">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align:center;padding:30px;color:#999">No hay servicios registrados para esta especialidad</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="?url=especialidades/listar" class="btn btn-secondary">Volver a especialidades</a>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

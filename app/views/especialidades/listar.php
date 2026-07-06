<?php $titulo = "Especialidades - Sistema de Citas Medicas"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1>Especialidades registradas</h1>
        <a href="?url=especialidades/crear" class="btn btn-success">+ Nueva especialidad</a>
    </div>

    <?php if (isset($_GET["msg"]) && $_GET["msg"] !== ""): ?>
        <div class="msg msg-exito"><?= htmlspecialchars($_GET["msg"]) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($especialidades)): ?>
                <?php foreach ($especialidades as $e): ?>
                    <tr>
                        <td><?= htmlspecialchars($e["id"]) ?></td>
                        <td><strong><?= htmlspecialchars($e["nombre"]) ?></strong></td>
                        <td>
                            <div class="acciones">
                                <a href="?url=servicios/listar&especialidad_id=<?= $e["id"] ?>" class="btn btn-primary btn-sm">Servicios</a>
                                <a href="?url=especialidades/editar&id=<?= $e["id"] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="?url=especialidades/eliminar&id=<?= $e["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta especialidad?')">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align:center;padding:30px;color:#999">No hay especialidades registradas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

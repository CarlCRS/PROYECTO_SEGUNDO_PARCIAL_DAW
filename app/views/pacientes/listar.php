<?php $titulo = "Pacientes - Sistema de Citas Medicas"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1>Pacientes registrados</h1>
        <a href="?url=pacientes/crear" class="btn btn-success">+ Nuevo paciente</a>
    </div>

    <?php if (isset($_GET["msg"]) && $_GET["msg"] !== ""): ?>
        <div class="msg msg-exito"><?= htmlspecialchars($_GET["msg"]) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cedula</th>
                <th>Telefono</th>
                <th>Fecha nac.</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pacientes)): ?>
                <?php foreach ($pacientes as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p["id"]) ?></td>
                        <td><strong><?= htmlspecialchars($p["nombre"]) ?></strong></td>
                        <td><?= htmlspecialchars($p["cedula"]) ?></td>
                        <td><?= htmlspecialchars($p["telefono"]) ?></td>
                        <td><?= htmlspecialchars($p["fecha_nacimiento"]) ?></td>
                        <td>
                            <div class="acciones">
                                <a href="?url=antecedentes/listar&paciente_id=<?= $p["id"] ?>" class="btn btn-primary btn-sm">Antecedentes</a>
                                <a href="?url=pacientes/editar&id=<?= $p["id"] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="?url=pacientes/eliminar&id=<?= $p["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este paciente?')">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;padding:30px;color:#999">No hay pacientes registrados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

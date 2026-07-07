<?php $titulo = "Antecedentes - Sistema de Citas Medicas"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="card">
    <div class="card-header">
        <h1>Antecedentes de <?= htmlspecialchars($paciente_nombre) ?></h1>
        <a href="?url=antecedentes/crear&paciente_id=<?= $paciente_id ?>" class="btn btn-primary">+ Nuevo antecedente</a>
    </div>

    <?php if (isset($_GET["msg"]) && $_GET["msg"] !== ""): ?>
        <div class="msg msg-exito"><?= htmlspecialchars($_GET["msg"]) ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripcion</th>
                    <th>Fecha registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($antecedentes)): ?>
                    <?php foreach ($antecedentes as $a): ?>
                        <tr>
                            <td><?= htmlspecialchars($a["id"]) ?></td>
                            <td><?= htmlspecialchars($a["descripcion"]) ?></td>
                            <td><?= htmlspecialchars($a["fecha_registro"]) ?></td>
                            <td>
                                <div class="acciones">
                                    <a href="?url=antecedentes/editar&id=<?= $a["id"] ?>" class="btn btn-ghost btn-sm">Editar</a>
                                    <a href="?url=antecedentes/eliminar&id=<?= $a["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este antecedente?')">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="empty-table">No hay antecedentes registrados para este paciente</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="?url=pacientes/listar" class="btn btn-ghost" style="margin-top:16px">Volver a pacientes</a>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

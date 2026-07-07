<?php $titulo = "Inicio - Sistema de Citas Medicas"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<?php if (isset($_SESSION["usuario"])): ?>

    <div class="hero">
        <span class="badge">Bienvenido, <?= htmlspecialchars($_SESSION["usuario"]) ?> 🎉</span>
        <h1>Sistema de Gestion de Citas Medicas</h1>
        <p>Seleccione un modulo para comenzar a gestionar la informacion.</p>
    </div>

    <?php if (isset($_GET["msg"]) && $_GET["msg"] !== ""): ?>
        <div class="msg msg-exito"><?= htmlspecialchars($_GET["msg"]) ?></div>
    <?php endif; ?>

    <div class="grid-cards">
        <a href="?url=pacientes/listar" class="modulo-card">
            <div class="icono">👤</div>
            <h3>Pacientes</h3>
            <p>Registre, edite y consulte la informacion de pacientes</p>
        </a>

        <a href="?url=pacientes/listar" class="modulo-card">
            <div class="icono">📋</div>
            <h3>Antecedentes</h3>
            <p>Historial clinico y antecedentes por paciente</p>
        </a>

        <a href="#" class="modulo-card" style="opacity:0.5">
            <div class="icono">🩺</div>
            <h3>Medicos</h3>
            <p>Gestion de medicos y especialidades (proximamente)</p>
        </a>

        <a href="#" class="modulo-card" style="opacity:0.5">
            <div class="icono">📅</div>
            <h3>Horarios</h3>
            <p>Disponibilidad de medicos (proximamente)</p>
        </a>

        <a href="#" class="modulo-card" style="opacity:0.5">
            <div class="icono">🏥</div>
            <h3>Especialidades</h3>
            <p>Administracion de especialidades (proximamente)</p>
        </a>

        <a href="#" class="modulo-card" style="opacity:0.5">
            <div class="icono">💰</div>
            <h3>Servicios</h3>
            <p>Tarifas y servicios por especialidad (proximamente)</p>
        </a>

        <a href="#" class="modulo-card" style="opacity:0.5">
            <div class="icono">📆</div>
            <h3>Citas</h3>
            <p>Agendamiento y control de citas (proximamente)</p>
        </a>

        <a href="#" class="modulo-card" style="opacity:0.5">
            <div class="icono">💳</div>
            <h3>Pagos</h3>
            <p>Registro de pagos por cita (proximamente)</p>
        </a>
    </div>

<?php else: ?>

    <div style="text-align:center;padding:80px 20px">
        <div style="font-size:80px;margin-bottom:20px">🏥</div>
        <h1 style="font-size:36px;color:#1a5276;margin-bottom:15px">Sistema de Citas Medicas</h1>
        <p style="font-size:17px;color:#7f8c8d;max-width:550px;margin:0 auto 30px;line-height:1.7">
            Plataforma para la gestion de pacientes, medicos, especialidades y citas medicas.
        </p>
        <div style="display:flex;gap:15px;justify-content:center">
            <a href="?url=auth/login" class="btn btn-primary" style="padding:12px 30px;font-size:16px">Iniciar sesion</a>
            <a href="?url=auth/registro" class="btn btn-success" style="padding:12px 30px;font-size:16px">Crear cuenta</a>
        </div>
    </div>

<?php endif; ?>

<?php require __DIR__ . "/../layout/footer.php" ?>

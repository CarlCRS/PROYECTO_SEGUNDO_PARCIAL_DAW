<?php $titulo = "Inicio - Sistema de Citas Medicas"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="hero">
    <span class="badge">Desarrollo Web con PHP y MySQL</span>
    <h1>Sistema de Gestion de Citas Medicas</h1>
    <p>Plataforma integral para la administracion de pacientes, medicos, especialidades y citas medicas. Desarrollada con arquitectura MVC.</p>
</div>

<div class="grid-cards">

    <a href="?url=pacientes/listar" class="modulo-card">
        <div class="icono">👤</div>
        <h3>Pacientes</h3>
        <p>Registre, edite y consulte la informacion de pacientes</p>
    </a>

    <a href="?url=antecedentes/listar&paciente_id=0" class="modulo-card">
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

<?php require __DIR__ . "/../layout/footer.php" ?>
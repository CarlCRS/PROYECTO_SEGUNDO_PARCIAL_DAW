<?php $titulo = "Inicio - Sistema de Citas Medicas"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="hero">
    <span class="badge">Desarrollo Web con PHP y MySQL</span>
    <h1>Sistema de Gestion de Citas Medicas</h1>
    <p>Plataforma integral para la administracion de pacientes, medicos, especialidades y citas medicas. Desarrollada con arquitectura MVC.</p>
</div>

<div class="grid-cards">

    <a href="?url=pacientes/listar" class="modulo-card">
        <div class="icono">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary-light)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
        </div>
        <h3>Pacientes</h3>
        <p>Registre, edite y consulte la informacion de pacientes</p>
    </a>

    <a href="?url=antecedentes/listar&paciente_id=0" class="modulo-card">
        <div class="icono">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary-light)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
                <polyline points="10 9 9 9 8 9"/>
            </svg>
        </div>
        <h3>Antecedentes</h3>
        <p>Historial clinico y antecedentes por paciente</p>
    </a>

    <a href="?url=medicos/listar" class="modulo-card">
        <div class="icono">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary-light)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
            </svg>
        </div>
        <h3>Medicos</h3>
        <p>Gestion de medicos y sus especialidades</p>
    </a>

    <a href="?url=medicos/listar" class="modulo-card">
        <div class="icono">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary-light)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
                <line x1="12" y1="14" x2="12" y2="18"/>
                <line x1="10" y1="16" x2="14" y2="16"/>
            </svg>
        </div>
        <h3>Horarios</h3>
        <p>Disponibilidad de medicos por dia y hora</p>
    </a>

    <a href="?url=especialidades/listar" class="modulo-card">
        <div class="icono">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary-light)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                <circle cx="12" cy="12" r="2"/>
            </svg>
        </div>
        <h3>Especialidades</h3>
        <p>Administracion de especialidades medicas</p>
    </a>

    <a href="?url=especialidades/listar" class="modulo-card">
        <div class="icono">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary-light)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
        </div>
        <h3>Servicios</h3>
        <p>Tarifas y servicios por especialidad</p>
    </a>

    <a href="?url=citas/listar" class="modulo-card">
        <div class="icono">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary-light)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
                <circle cx="12" cy="16" r="1"/>
                <circle cx="16" cy="16" r="1"/>
                <circle cx="8" cy="16" r="1"/>
            </svg>
        </div>
        <h3>Citas</h3>
        <p>Agendamiento y control de citas medicas</p>
    </a>

    <a href="?url=citas/listar" class="modulo-card">
        <div class="icono">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary-light)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="2"/>
                <line x1="1" y1="10" x2="23" y2="10"/>
                <circle cx="8" cy="16" r="1"/>
                <circle cx="16" cy="16" r="1"/>
            </svg>
        </div>
        <h3>Pagos</h3>
        <p>Registro de pagos por cita</p>
    </a>

</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? "Sistema de Citas Medicas" ?></title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <div class="notification-bar" id="notificationBar">
        <div class="notif-container">
            <div class="notif-track-wrap">
                <div class="notif-track" id="notifTrack">
                    <div class="notif-slide">
                        <svg class="notif-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>
                        </svg>
                        <strong>Horario:</strong>
                        <span>Lun - Vie 8:00 AM - 6:00 PM | Sab 8:00 AM - 12:00 PM</span>
                    </div>
                    <div class="notif-slide">
                        <svg class="notif-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                        </svg>
                        <strong>Descuento:</strong>
                        <span>15% en consulta general todos los martes - Aprovecha la promocion</span>
                    </div>
                    <div class="notif-slide">
                        <svg class="notif-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="4" width="20" height="16" rx="2"/><path d="M9 12h6M12 9v6"/>
                        </svg>
                        <strong>Nuevo servicio:</strong>
                        <span>Consultas via telemedicina disponibles - Agenda desde casa</span>
                    </div>
                </div>
            </div>
            <div class="notif-dots" id="notifDots"></div>
        </div>
    </div>

    <nav class="navbar">
        <a href="?url=inicio" class="logo">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 12h6M12 9v6"/>
                <rect x="2" y="4" width="20" height="16" rx="2"/>
            </svg>
            Clinica Salud
        </a>

        <button class="hamburger" id="hamburger" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <?php if (isset($_SESSION["usuario"])): ?>
            <ul class="nav-links" id="navLinks">
                <li><a href="?url=inicio" class="<?= ($url === 'inicio') ? 'active' : '' ?>">Inicio</a></li>
                <li><a href="?url=pacientes/listar" class="<?= str_starts_with($url, 'pacientes') ? 'active' : '' ?>">Pacientes</a></li>
                <li><a href="?url=medicos/listar" class="<?= str_starts_with($url, 'medicos') ? 'active' : '' ?>">Medicos</a></li>
                <li><a href="?url=especialidades/listar" class="<?= str_starts_with($url, 'especialidades') ? 'active' : '' ?>">Especialidades</a></li>
                <li><a href="?url=citas/listar" class="<?= str_starts_with($url, 'citas') ? 'active' : '' ?>">Citas</a></li>
                <li class="user-badge-mobile">
                    <span class="user-name"><?= htmlspecialchars($_SESSION["usuario"]) ?></span>
                    <span class="role-tag"><?= htmlspecialchars($_SESSION["rol"]) ?></span>
                    <a href="?url=auth/logout" class="logout-link">Cerrar sesion</a>
                </li>
            </ul>
            <div class="nav-right">
                <button class="theme-toggle" id="themeToggle" aria-label="Cambiar tema">
                    <svg class="icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                    </svg>
                    <svg class="icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                    </svg>
                </button>
                <div class="user-badge">
                    <span class="user-name"><?= htmlspecialchars($_SESSION["usuario"]) ?></span>
                    <span class="role-tag"><?= htmlspecialchars($_SESSION["rol"]) ?></span>
                    <a href="?url=auth/logout" class="logout-link">Cerrar sesion</a>
                </div>
            </div>
        <?php else: ?>
            <ul class="nav-links" id="navLinks">
                <li><a href="?url=inicio">Inicio</a></li>
                <li><a href="?url=auth/login">Iniciar sesion</a></li>
                <li><a href="?url=auth/registro">Registrarse</a></li>
            </ul>
            <div class="nav-right">
                <button class="theme-toggle" id="themeToggle" aria-label="Cambiar tema">
                    <svg class="icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                    </svg>
                    <svg class="icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                    </svg>
                </button>
            </div>
        <?php endif; ?>
    </nav>

    <div class="main-container">

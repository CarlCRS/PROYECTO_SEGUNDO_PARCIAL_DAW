<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? "Sistema de Citas Medicas" ?></title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <nav class="navbar">
        <a href="?url=inicio" class="logo">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 12h6M12 9v6"/>
                <rect x="2" y="4" width="20" height="16" rx="2"/>
            </svg>
            Clinica Salud
        </a>

        <?php if (isset($_SESSION["usuario"])): ?>
            <ul class="nav-links">
                <li><a href="?url=inicio" class="<?= ($url === 'inicio') ? 'active' : '' ?>">Inicio</a></li>
                <li><a href="?url=pacientes/listar" class="<?= str_starts_with($url, 'pacientes') ? 'active' : '' ?>">Pacientes</a></li>
                <li><a href="?url=medicos/listar" class="<?= str_starts_with($url, 'medicos') ? 'active' : '' ?>">Medicos</a></li>
                <li><a href="?url=especialidades/listar" class="<?= str_starts_with($url, 'especialidades') ? 'active' : '' ?>">Especialidades</a></li>
                <li><a href="?url=citas/listar" class="<?= str_starts_with($url, 'citas') ? 'active' : '' ?>">Citas</a></li>
                <li style="color:rgba(255,255,255,0.7);padding:10px 8px;font-size:13px">
                    👤 <?= htmlspecialchars($_SESSION["usuario"]) ?>
                    <span style="background:rgba(255,255,255,0.15);padding:2px 8px;border-radius:10px;font-size:11px;margin-left:4px">
                        <?= htmlspecialchars($_SESSION["rol"]) ?>
                    </span>
                </li>
                <li><a href="?url=auth/logout" style="color:#f5b7b1">Cerrar sesion</a></li>
            </ul>
        <?php else: ?>
            <ul class="nav-links">
                <li><a href="?url=inicio">Inicio</a></li>
                <li><a href="?url=auth/login">Iniciar sesion</a></li>
                <li><a href="?url=auth/registro">Registrarse</a></li>
            </ul>
        <?php endif; ?>
    </nav>

    <div class="main-container">

<?php $titulo = "Crear cuenta"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="auth-container">
    <div class="card">
        <span class="auth-icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary-light)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="8.5" cy="7" r="4"/>
                <polyline points="17 11 19 13 23 9"/>
            </svg>
        </span>
        <h1>Crear cuenta</h1>
        <p class="auth-subtitle">Registrese como paciente en el sistema</p>

        <?php if (!empty($errores)): ?>
            <div class="msg msg-error">
                <ul style="margin-left:18px">
                    <?php foreach ($errores as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="?url=auth/registrar">
            <label>Nombre completo</label>
            <input type="text" name="nombre" required>

            <label>Correo electronico</label>
            <input type="email" name="email" required>

            <label>Cedula</label>
            <input type="text" name="cedula" required>

            <label>Telefono (opcional)</label>
            <input type="text" name="telefono">

            <label>Contraseña</label>
            <input type="password" name="password" minlength="6" required>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-full">Crear cuenta</button>
            </div>
        </form>

        <p class="auth-footer">
            ¿Ya tienes cuenta?
            <a href="?url=auth/login">Iniciar sesion</a>
        </p>
    </div>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

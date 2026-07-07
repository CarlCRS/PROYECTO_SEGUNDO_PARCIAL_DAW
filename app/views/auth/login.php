<?php $titulo = "Iniciar sesion"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div class="auth-container">
    <div class="card">
        <span class="auth-icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary-light)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 12h6M12 9v6"/>
                <rect x="2" y="4" width="20" height="16" rx="2"/>
            </svg>
        </span>
        <h1>Iniciar sesion</h1>
        <p class="auth-subtitle">Ingrese sus credenciales para acceder</p>

        <?php if (isset($_GET["msg"]) && $_GET["msg"] !== ""): ?>
            <div class="msg msg-exito"><?= htmlspecialchars($_GET["msg"]) ?></div>
        <?php endif; ?>

        <?php if (!empty($errores)): ?>
            <div class="msg msg-error">
                <ul style="margin-left:18px">
                    <?php foreach ($errores as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="?url=auth/autenticar">
            <label>Correo electronico</label>
            <input type="email" name="email" required>

            <label>Contraseña</label>
            <input type="password" name="password" required>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-full">Ingresar</button>
            </div>
        </form>

        <p class="auth-footer">
            ¿No tienes cuenta?
            <a href="?url=auth/registro">Registrarse</a>
        </p>
    </div>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

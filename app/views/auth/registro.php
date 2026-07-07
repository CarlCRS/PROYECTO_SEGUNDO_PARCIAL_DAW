<?php $titulo = "Crear cuenta"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div style="max-width:400px;margin:40px auto">
    <div class="card">
        <div style="text-align:center;margin-bottom:25px">
            <div style="font-size:48px;margin-bottom:10px">📝</div>
            <h1 style="font-size:22px;color:#1a5276">Crear cuenta</h1>
            <p style="color:#7f8c8d;font-size:14px">Registrese como paciente en el sistema</p>
        </div>

        <?php if (!empty($errores)): ?>
            <div class="msg msg-error">
                <ul style="margin-left:18px">
                    <?php foreach ($errores as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="?url=auth/registrar" style="margin:0 auto">
            <label>Nombre completo</label>
            <input type="text" name="nombre" required>

            <label>Correo electronico</label>
            <input type="email" name="email" required>

            <label>Contraseña</label>
            <input type="password" name="password" minlength="6" required>

            <br><br>
            <button type="submit" class="btn btn-success" style="width:100%">Crear cuenta</button>
        </form>

        <p style="text-align:center;margin-top:20px;font-size:14px;color:#7f8c8d">
            ¿Ya tienes cuenta?
            <a href="?url=auth/login" style="color:#2e86c1;text-decoration:none;font-weight:600">Iniciar sesion</a>
        </p>
    </div>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

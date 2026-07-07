<?php $titulo = "Iniciar sesion"; ?>
<?php require __DIR__ . "/../layout/header.php" ?>

<div style="max-width:400px;margin:40px auto">
    <div class="card">
        <div style="text-align:center;margin-bottom:25px">
            <div style="font-size:48px;margin-bottom:10px">🏥</div>
            <h1 style="font-size:22px;color:#1a5276">Iniciar sesion</h1>
            <p style="color:#7f8c8d;font-size:14px">Ingrese sus credenciales para acceder</p>
        </div>

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

        <form method="POST" action="?url=auth/autenticar" style="margin:0 auto">
            <label>Correo electronico</label>
            <input type="email" name="email" required>

            <label>Contraseña</label>
            <input type="password" name="password" required>

            <br><br>
            <button type="submit" class="btn btn-primary" style="width:100%">Ingresar</button>
        </form>

        <p style="text-align:center;margin-top:20px;font-size:14px;color:#7f8c8d">
            ¿No tienes cuenta?
            <a href="?url=auth/registro" style="color:#2e86c1;text-decoration:none;font-weight:600">Registrarse</a>
        </p>
    </div>
</div>

<?php require __DIR__ . "/../layout/footer.php" ?>

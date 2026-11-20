<h1>Iniciar sesión</h1>

<?php if ($registrado): ?>
    <p class="exito">Registro correcto, ya puedes iniciar sesión.</p>
<?php endif; ?>

<?php if (!empty($errores)): ?>
    <ul class="errores">
        <?php foreach ($errores as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="index.php?accion=login">
    <p>
        <label for="email">Correo electrónico</label><br>
        <input type="text" id="email" name="email"
               value="<?= htmlspecialchars($datos['email'] ?? '') ?>">
    </p>
    <p>
        <label for="password">Contraseña</label><br>
        <input type="password" id="password" name="password">
    </p>
    <button type="submit">Entrar</button>
</form>

<p>¿No tienes cuenta? <a href="index.php?accion=registro">Regístrate</a></p>
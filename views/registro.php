<h1>Registro de jugador</h1>

<?php if (!empty($errores)): ?>
    <ul class="errores">
        <?php foreach ($errores as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="index.php?accion=registro">
    <p>
        <label for="username">Nombre de usuario</label><br>
        <input type="text" id="username" name="username"
               value="<?= htmlspecialchars($datos['username'] ?? '') ?>">
    </p>
    <p>
        <label for="email">Correo electrónico</label><br>
        <input type="text" id="email" name="email"
               value="<?= htmlspecialchars($datos['email'] ?? '') ?>">
    </p>
    <p>
        <label for="password">Contraseña</label><br>
        <input type="password" id="password" name="password">
    </p>
    <p>
        <label for="password2">Confirmar contraseña</label><br>
        <input type="password" id="password2" name="password2">
    </p>
    <button type="submit">Registrarse</button>
</form>
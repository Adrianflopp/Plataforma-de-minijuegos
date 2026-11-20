<h1>Plataforma de Minijuegos</h1>
<p>Juegos subidos: <?= htmlspecialchars((string) $totalJuegos) ?> · Jugadores 
registrados: <?= htmlspecialchars((string) $totalJugadores) ?></p>

<?php if ($usuario === null): ?>
    <p>Bienvenido, visitante.</p>
    <ul>
        <li><a href="index.php?accion=registro">Registrarse</a></li>
        <li><a href="index.php?accion=login">Iniciar sesión</a></li>
    </ul>
<?php else: ?>
    <p>¡Bienvenido, <?= htmlspecialchars($usuario) ?>!</p>
    <ul>
        <li><a href="index.php?accion=subir">Subir un nuevo juego</a></li>
        <li><a href="index.php?accion=juegos">Ver juegos subidos</a></li>
        <li><a href="index.php?accion=logout">Cerrar sesión</a></li>
    </ul>
<?php endif; ?>
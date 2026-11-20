<h1>Juegos subidos</h1>


<form method="get" action="index.php" class="filtro">
    <input type="hidden" name="accion" value="juegos">
    <label for="categoria">Categoría:</label>
    <select id="categoria" name="categoria">
        <option value="">Todas</option>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?= htmlspecialchars($categoria) ?>"
                <?= ($datos['categoria'] ?? '') === $categoria ? 'selected' : '' ?>>
                <?= htmlspecialchars($categoria) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filtrar</button>
</form>

<?php if (!empty($errores)): ?>
    <ul class="errores">
        <?php foreach ($errores as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (empty($juegos)): ?>
    <?php if (($datos['categoria'] ?? '') !== '' && empty($errores)): ?>
        <p>No hay juegos en la categoría <?= htmlspecialchars($datos['categoria']) ?></p>
    <?php else: ?>
        <p>Todavía no hay juegos subidos</p>
    <?php endif; ?>
<?php else: ?>
    <?php foreach ($juegos as $juego): ?>
        <article class="juego">
            <p><strong>Título:</strong> <?= htmlspecialchars($juego['titulo']) ?></p>
            <p><strong>Autor:</strong> <?= htmlspecialchars($juego['autor']) ?></p>
            <p><strong>Categoría:</strong> <?= htmlspecialchars($juego['categoria']) ?></p>
            <?php if (isset($juego['fecha'])): ?>
                <p><strong>Fecha:</strong> <?= htmlspecialchars($juego['fecha']) ?></p>
            <?php endif; ?>
            <p><strong>Descripción:</strong> <?= htmlspecialchars($juego['descripcion']) ?></p>
            <p><a class="boton" href="<?= htmlspecialchars($juego['archivo']) ?>" download>Descargar ZIP</a></p>
        </article>
    <?php endforeach; ?>
<?php endif; ?>
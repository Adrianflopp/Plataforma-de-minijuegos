<h1>Juegos subidos</h1>

<?php if (empty($juegos)): ?>
    <p>Todavía no hay juegos subidos</p>
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
            <p><a href="<?= htmlspecialchars($juego['archivo']) ?>" download>Descargar ZIP</a></p>
        </article>
        <hr>
    <?php endforeach; ?>
<?php endif; ?> 
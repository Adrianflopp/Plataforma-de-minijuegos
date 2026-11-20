<h1>Subir un nuevo juego</h1>

<?php if (!empty($errores)): ?>
    <ul class="errores">
        <?php foreach ($errores as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="index.php?accion=subir" enctype="multipart/form-data">
    <p>
        <label for="titulo">Título del juego</label><br>
        <input type="text" id="titulo" name="titulo"
               value="<?= htmlspecialchars($datos['titulo'] ?? '') ?>">
    </p>
    <p>
        <label for="descripcion">Descripción</label><br>
        <textarea id="descripcion" name="descripcion" rows="5" cols="40"><?= htmlspecialchars($datos['descripcion'] ?? '') ?></textarea>
    </p>
    <p>
        <label for="categoria">Categoría</label><br>
        <select id="categoria" name="categoria">
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= htmlspecialchars($categoria) ?>"
                    <?= ($datos['categoria'] ?? '') === $categoria ? 'selected' : '' ?>>
                    <?= htmlspecialchars($categoria) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <label for="archivo">Archivo ZIP</label><br>
        <input type="file" id="archivo" name="archivo">
    </p>
    <button type="submit">Subir juego</button>
</form>
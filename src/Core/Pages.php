<?php

declare(strict_types=1);

class Pages
{
    public function mostrar(string $vista, array $datos = []): void
    {
        extract($datos);

        require RUTA_VIEWS . '/header.php';
        require RUTA_VIEWS . '/' . $vista . '.php';
        require RUTA_VIEWS . '/footer.php';
    }
}
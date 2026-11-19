<?php
declare(strict_types=1);


class Pages
{

    public function mostrar(string $vista, array $datos = []): void
    {
        // Extraemos las variables para que estén disponibles en la vista
        extract($datos);

        // Cabecera común
        require RUTA_VIEWS . '/cabecera.php';

        // Contenido propio de la página
        $rutaVista = RUTA_VIEWS . '/' . $vista . '.php';
        if (file_exists($rutaVista)) {
            require $rutaVista;
        } else {
            echo '<p>Error: la vista solicitada no existe.</p>';
        }

        // Pie común
        require RUTA_VIEWS . '/pie.php';
    }
}
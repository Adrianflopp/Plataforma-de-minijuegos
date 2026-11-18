<?php
declare(strict_types=1);

/**
 * Clase de apoyo para mostrar las vistas.
 * Siempre añade la cabecera y el pie comunes.
 */
class Pages
{
    /**
     * Muestra una vista dentro de la estructura común (cabecera + pie).
     *
     * @param string $vista  Nombre del fichero de la vista (sin .php)
     * @param array  $datos  Variables que se pasarán a la vista
     */
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
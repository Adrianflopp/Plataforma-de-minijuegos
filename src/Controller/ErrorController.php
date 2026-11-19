<?php

declare(strict_types=1);

class ErrorController
{
    public function error404(): void
    {
        http_response_code(404);

        $pages = new Pages();
        $pages->mostrar('404', [
            'titulo'  => 'Página no encontrada',
            'mensaje' => 'La página o acción solicitada no existe.'
        ]);
    }

    public function error500(): void
    {
        http_response_code(500);

        $pages = new Pages();
        $pages->mostrar('500', [
            'titulo'  => 'Error interno del servidor',
            'mensaje' => 'Ha ocurrido un error inesperado. Por favor, inténtalo de nuevo más tarde.'
        ]);
    }
}
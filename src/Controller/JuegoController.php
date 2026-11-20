<?php
declare(strict_types=1);

class JuegoController
{
    public function subir(): void
    {
        $pages = new Pages();

        // GET: formulario vacío con la lista de categorías
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $pages->mostrar('subir_juego', [
                'errores'    => [],
                'datos'      => [],
                'categorias' => CATEGORIAS,
            ]);
            return;
        }

        // POST: la Request sanea y valida textos y archivo
        $request = new formSubirJuegoRequest($_POST, $_FILES);

        // Si hay errores, volvemos a mostrar el formulario
        if (!$request->esValido()) {
            $pages->mostrar('subir_juego', [
                'errores'    => $request->errores(),
                'datos'      => $request->datos(),
                'categorias' => CATEGORIAS,
            ]);
            return;
        }

        // Todo correcto: el modelo guarda el ZIP y el registro
        $modelo = new JuegoModel(RUTA_JUEGOS, RUTA_UPLOADS);
        $modelo->guardar([
            'titulo'          => $request->titulo(),
            'descripcion'     => $request->descripcion(),
            'categoria'       => $request->categoria(),
            'nombre_original' => $request->nombreOriginal(),
            'autor'           => 'invitado', // hasta que haya sesiones
        ], $request->rutaTemporal());

        header('Location: index.php?accion=juegos');
        exit;
    }
}
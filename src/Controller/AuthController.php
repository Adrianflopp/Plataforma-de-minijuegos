<?php
declare(strict_types=1);

class AuthController
{
    public function registro(): void
    {
        $pages = new Pages();

        // GET: mostramos el formulario vacío
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $pages->mostrar('registro', ['errores' => [], 'datos' => []]);
            return;
        }

        // POST: la Request sanea y valida
        $request = new formRegistroRequest($_POST);
        $modelo  = new JugadorModel(RUTA_JUGADORES);

        // Si los datos son válidos, preguntamos al modelo si ya existen
        if ($request->esValido()) {
            if ($modelo->existeUsername($request->username())) {
                $request->agregarError('username', 'Ese nombre de usuario ya está en uso.');
            }
            if ($modelo->existeEmail($request->email())) {
                $request->agregarError('email', 'Ese correo ya está registrado.');
            }
        }

        // Si hay errores, volvemos a mostrar el formulario
        if (count($request->errores()) > 0) {
            $pages->mostrar('registro', [
                'errores' => $request->errores(),
                'datos'   => $request->datos(),
            ]);
            return;
        }

        // Todo correcto: guardamos y redirigimos
        $modelo->crear($request->username(), $request->email(), $request->password());

        header('Location: index.php?' . http_build_query(['accion' => 'login', 'registrado' => 1]));
        exit;
    }
}
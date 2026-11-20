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

    public function login(): void
    {
        $pages = new Pages();

        // GET: mostramos el formulario
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $pages->mostrar('login', [
                'errores'    => [],
                'datos'      => [],
                'registrado' => isset($_GET['registrado']),
            ]);
            return;
        }

        // POST: la Request sanea y valida
        $request = new formLoginRequest($_POST);

        if ($request->esValido()) {
            $modelo  = new JugadorModel(RUTA_JUGADORES);
            $jugador = $modelo->verificarCredenciales($request->email(), $request->password());

            // Mismo mensaje tanto si falla el correo como la contraseña
            if ($jugador === null) {
                $request->agregarError('general', 'Email o contraseña incorrectos.');
            }
        }

        // Si hay errores, volvemos a mostrar el formulario
        if (count($request->errores()) > 0) {
            $pages->mostrar('login', [
                'errores'    => $request->errores(),
                'datos'      => $request->datos(),
                'registrado' => false,
            ]);
            return;
        }

        // Todo correcto: redirigimos a home con el nombre del usuario
        header('Location: index.php?' . http_build_query([
            'accion'     => 'home',
            'bienvenido' => $jugador['username'],
        ]));
        exit;
    }

    public function logout(): void
    {
        // 1. Iniciamos la sesión
        session_start();

        // 2. La vaciamos y la destruimos
        $_SESSION = [];
        session_destroy();

        // 3. Redirigimos a home
        header('Location: index.php?accion=home');
        exit;
    }
}
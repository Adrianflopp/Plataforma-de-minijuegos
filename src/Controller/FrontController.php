<?php

declare(strict_types=1);

class FrontController
{
    private array $rutas = [
        'home'     => ['controlador' => 'HomeController',  'metodo' => 'index'],
        'registro' => ['controlador' => 'AuthController',  'metodo' => 'registro'],
        'login'    => ['controlador' => 'AuthController',  'metodo' => 'login'],
        'logout'   => ['controlador' => 'AuthController',  'metodo' => 'logout'],
        'subir'    => ['controlador' => 'JuegoController', 'metodo' => 'subir'],
        'juegos'   => ['controlador' => 'JuegoController', 'metodo' => 'listar'],
    ];

    public function manejarPeticion(): void
    {
        $accion = $_GET['accion'] ?? 'home';


        if (!array_key_exists($accion, $this->rutas)) {
            $errorController = new ErrorController();
            $errorController->error404();
            return;
        }

        $nombreControlador = $this->rutas[$accion]['controlador'];
        $metodo = $this->rutas[$accion]['metodo'];

        $controlador = new $nombreControlador();
        $controlador->$metodo();
    }
}
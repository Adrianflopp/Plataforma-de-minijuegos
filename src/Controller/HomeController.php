<?php
declare(strict_types=1);

class HomeController
{
    public function index(): void
    {
        $usuario = $_GET['bienvenido'] ?? null;

        if ($usuario === '') {
            $usuario = null;
        }

        $pages = new Pages();
        $pages->mostrar('home', ['usuario' => $usuario]);
    }
}
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

       
        $modeloJuegos    = new JuegoModel(RUTA_JUEGOS, RUTA_UPLOADS);
        $modeloJugadores = new JugadorModel(RUTA_JUGADORES);

        $pages = new Pages();
        $pages->mostrar('home', [
            'usuario'        => $usuario,
            'totalJuegos'    => $modeloJuegos->total(),
            'totalJugadores' => $modeloJugadores->total(),
        ]);
    }
}
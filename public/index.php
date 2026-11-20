<?php
declare(strict_types=1);

// Cargamos la configuración y el autoloader (están una carpeta por encima)
require __DIR__ . '/../config.php';
require __DIR__ . '/../autoloader.php';

try {
    $front = new FrontController();
    $front->manejarPeticion();
} catch (Throwable $e) {
    // Si algo falla, mostramos la página 500 sin enseñar detalles técnicos
    $error = new ErrorController();
    $error->error500();
}

<?php
declare(strict_types=1);

spl_autoload_register(function (string $clase): void {
    $carpetas = ['Controller', 'Core', 'Request', 'Model'];

    foreach ($carpetas as $carpeta) {
        $fichero = __DIR__ . '/src/' . $carpeta . '/' . $clase . '.php';

        if (file_exists($fichero)) {
            require $fichero;
            return;
        }
    }
});
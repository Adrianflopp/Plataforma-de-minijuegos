<?php
declare(strict_types=1);


spl_autoload_register(function (string $clase): void {
    $directorios = [
        __DIR__ . '/src/Controller/',
        __DIR__ . '/src/Core/',
        __DIR__ . '/src/Model/',
        __DIR__ . '/src/Request/',
    ];

    foreach ($directorios as $dir) {
        $archivo = $dir . $clase . '.php';
        if (file_exists($archivo)) {
            require_once $archivo;
            return;
        }
    }
});
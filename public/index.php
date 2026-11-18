<?php
declare(strict_types=1);

// Cargamos la configuración y el autoloader
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../autoloader.php';

// Arrancamos el FrontController
$frontController = new FrontController();
$frontController->manejarPeticion();
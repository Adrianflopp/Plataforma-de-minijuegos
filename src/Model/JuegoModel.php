<?php
declare(strict_types=1);

class JuegoModel
{
    private string $rutaJson;
    private string $rutaUploads;

    public function __construct(string $rutaJson, string $rutaUploads)
    {
        $this->rutaJson    = $rutaJson;
        $this->rutaUploads = $rutaUploads;
    }

    // Devuelve todos los juegos
    public function todos(): array
    {
        if (!file_exists($this->rutaJson)) {
            return [];
        }

        $json = file_get_contents($this->rutaJson);
        if ($json === false || trim($json) === '') {
            return [];
        }

        // Si el JSON está corrupto lanza una excepción (y se verá la página 500)
        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    // Guarda el ZIP en disco y registra el juego en el JSON
    public function guardar(array $datos, string $rutaTemporal): void
    {
        // 1. Si no existe la carpeta de subidas, la creamos
        if (!is_dir($this->rutaUploads)) {
            mkdir($this->rutaUploads, 0755, true);
        }

        // 2. Nombre: fecha y hora + parte aleatoria + nombre original saneado
        $nombreUnico = date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '_' . $datos['nombre_original'];

        // 3. Movemos el fichero temporal a su sitio
        $destino = $this->rutaUploads . '/' . $nombreUnico;
        if (!move_uploaded_file($rutaTemporal, $destino)) {
            throw new RuntimeException('No se pudo guardar el archivo subido.');
        }

        // 4. Si no existe la carpeta data/, la creamos
        $carpetaData = dirname($this->rutaJson);
        if (!is_dir($carpetaData)) {
            mkdir($carpetaData, 0755, true);
        }

        // 5. Leemos la lista, añadimos el juego y guardamos
        $juegos = $this->todos();

        $juegos[] = [
            'titulo'          => $datos['titulo'],
            'descripcion'     => $datos['descripcion'],
            'autor'           => $datos['autor'],
            'categoria'       => $datos['categoria'],
            'archivo'         => 'uploads/juegos/' . $nombreUnico,
            'nombre_original' => $datos['nombre_original'],
        ];

        $json = json_encode($juegos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        file_put_contents($this->rutaJson, $json, LOCK_EX);
    }
}
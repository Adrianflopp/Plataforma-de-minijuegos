<?php
declare(strict_types=1);

class formSubirJuegoRequest
{
    // Textos ya saneados
    private string $titulo;
    private string $descripcion;
    private string $categoria;

    // Información del fichero subido
    private array $archivo;

    private array $errores = [];

    public function __construct(array $post, array $files = [])
    {
        // Saneamos los textos
        $this->titulo      = strip_tags(trim($post['titulo'] ?? ''));
        $this->descripcion = strip_tags(trim($post['descripcion'] ?? ''));
        $this->categoria   = trim($post['categoria'] ?? '');

        // Guardamos el fichero
        $this->archivo = $files['archivo'] ?? [];
    }

    public function esValido(): bool
    {
        $this->validarTextos();
        $this->validarArchivo();

        return count($this->errores) === 0;
    }

    private function validarTextos(): void
    {
        // Título: obligatorio y entre 3 y 100 caracteres
        if ($this->titulo === '') {
            $this->errores['titulo'] = 'El título es obligatorio.';
        } elseif (mb_strlen($this->titulo) < 3 || mb_strlen($this->titulo) > 100) {
            $this->errores['titulo'] = 'El título debe tener entre 3 y 100 caracteres.';
        }

        // Descripción: obligatoria y como máximo 1000 caracteres
        if ($this->descripcion === '') {
            $this->errores['descripcion'] = 'La descripción es obligatoria.';
        } elseif (mb_strlen($this->descripcion) > 1000) {
            $this->errores['descripcion'] = 'La descripción no puede superar los 1000 caracteres.';
        }

        // Categoría: tiene que estar exactamente en CATEGORIAS
        if (!in_array($this->categoria, CATEGORIAS, true)) {
            $this->errores['categoria'] = 'La categoría no es válida.';
        }
    }

    private function validarArchivo(): void
    {
        // 1. Que se haya enviado un fichero y sin errores
        $codigoError = $this->archivo['error'] ?? UPLOAD_ERR_NO_FILE;

        if ($codigoError === UPLOAD_ERR_NO_FILE) {
            $this->errores['archivo'] = 'El archivo ZIP es obligatorio.';
            return;
        }
        if ($codigoError === UPLOAD_ERR_INI_SIZE || $codigoError === UPLOAD_ERR_FORM_SIZE) {
            $this->errores['archivo'] = 'El archivo es demasiado grande (máximo 10 MB).';
            return;
        }
        if ($codigoError !== UPLOAD_ERR_OK) {
            $this->errores['archivo'] = 'Ha ocurrido un error al subir el archivo.';
            return;
        }

        // 2. Que venga de una subida HTTP de verdad
        if (!is_uploaded_file($this->archivo['tmp_name'])) {
            $this->errores['archivo'] = 'El archivo no se ha subido correctamente.';
            return;
        }

        // 3. Extensión .zip (en minúsculas)
        $extension = strtolower(pathinfo($this->archivo['name'], PATHINFO_EXTENSION));
        if ($extension !== 'zip') {
            $this->errores['archivo'] = 'Solo se permiten archivos con extensión .zip.';
            return;
        }

        // 4. Tipo mime real
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $this->archivo['tmp_name']);

        if ($mime !== 'application/zip') {
            $this->errores['archivo'] = 'El archivo no es un ZIP válido.';
            return;
        }

        // 5. Tamaño máximo
        if ($this->archivo['size'] > MAX_ZIP) {
            $this->errores['archivo'] = 'El archivo es demasiado grande (máximo 10 MB).';
        }
    }

    public function errores(): array
    {
        return $this->errores;
    }

    public function agregarError(string $campo, string $mensaje): void
    {
        $this->errores[$campo] = $mensaje;
    }

    // Datos para volver a rellenar el formulario
    public function datos(): array
    {
        return [
            'titulo'      => $this->titulo,
            'descripcion' => $this->descripcion,
            'categoria'   => $this->categoria,
        ];
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function descripcion(): string
    {
        return $this->descripcion;
    }

    public function categoria(): string
    {
        return $this->categoria;
    }

    // Nombre original saneado: sin rutas y solo letras, números, guiones y puntos
    public function nombreOriginal(): string
    {
        $nombre = basename($this->archivo['name'] ?? '');
        return preg_replace('/[^A-Za-z0-9._-]/', '', $nombre);
    }

    public function rutaTemporal(): string
    {
        return $this->archivo['tmp_name'] ?? '';
    }
}
<?php
declare(strict_types=1);

class formFiltroJuegosRequest
{
    
    private string $categoria;

    private array $errores = [];

    
    public function __construct(array $post, array $files = [])
    {
        $this->categoria = trim($post['categoria'] ?? '');
    }

    public function esValido(): bool
    {
        
        if ($this->categoria !== '' && !in_array($this->categoria, CATEGORIAS, true)) {
            $this->errores['categoria'] = 'La categoría no es válida.';
        }

        return count($this->errores) === 0;
    }

    public function errores(): array
    {
        return $this->errores;
    }

    public function agregarError(string $campo, string $mensaje): void
    {
        $this->errores[$campo] = $mensaje;
    }

    public function datos(): array
    {
        return ['categoria' => $this->categoria];
    }

    public function categoria(): string
    {
        return $this->categoria;
    }
}
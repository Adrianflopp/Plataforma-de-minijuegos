<?php
declare(strict_types=1);

class formLoginRequest
{
    private string $email;
    // La contraseña no se sanea
    private string $password;

    private array $errores = [];

    public function __construct(array $post, array $files = [])
    {
        // Saneamos el correo
        $this->email = filter_var(trim($post['email'] ?? ''), FILTER_SANITIZE_EMAIL);

        // La contraseña se guarda tal cual
        $this->password = $post['password'] ?? '';
    }

    public function esValido(): bool
    {
        // Correo: obligatorio y con formato válido
        if ($this->email === '') {
            $this->errores['email'] = 'El correo es obligatorio.';
        } elseif (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errores['email'] = 'El correo no tiene un formato válido.';
        }

        // Contraseña: obligatoria
        if ($this->password === '') {
            $this->errores['password'] = 'La contraseña es obligatoria.';
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

    // Datos para volver a rellenar el formulario
    public function datos(): array
    {
        return ['email' => $this->email];
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
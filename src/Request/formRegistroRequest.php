<?php
declare(strict_types=1);

class formRegistroRequest
{
    // Datos ya saneados
    private string $username;
    private string $email;
    // Las contraseñas no se sanean
    private string $password;
    private string $password2;

    private array $errores = [];

    public function __construct(array $post, array $files = [])
    {
        // Saneamos usuario y correo
        $this->username = strip_tags(trim($post['username'] ?? ''));
        $this->email    = filter_var(trim($post['email'] ?? ''), FILTER_SANITIZE_EMAIL);

        // Las contraseñas se guardan tal cual
        $this->password  = $post['password'] ?? '';
        $this->password2 = $post['password2'] ?? '';
    }

    public function esValido(): bool
    {
        // Usuario: obligatorio y entre 3 y 20 caracteres
        if ($this->username === '') {
            $this->errores['username'] = 'El nombre de usuario es obligatorio.';
        } elseif (mb_strlen($this->username) < 3 || mb_strlen($this->username) > 20) {
            $this->errores['username'] = 'El usuario debe tener entre 3 y 20 caracteres.';
        }

        // Correo: obligatorio y con formato válido
        if ($this->email === '') {
            $this->errores['email'] = 'El correo es obligatorio.';
        } elseif (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errores['email'] = 'El correo no tiene un formato válido.';
        }

        // Contraseña: obligatoria y mínimo 8 caracteres
        if ($this->password === '') {
            $this->errores['password'] = 'La contraseña es obligatoria.';
        } elseif (mb_strlen($this->password) < 8) {
            $this->errores['password'] = 'La contraseña debe tener al menos 8 caracteres.';
        }

        // Confirmación: obligatoria e igual a la contraseña
        if ($this->password2 === '') {
            $this->errores['password2'] = 'Debes repetir la contraseña.';
        } elseif ($this->password !== $this->password2) {
            $this->errores['password2'] = 'Las contraseñas no coinciden.';
        }

        return count($this->errores) === 0;
    }

    public function errores(): array
    {
        return $this->errores;
    }

    // Para errores que dependen del usuario o correo repetido
    public function agregarError(string $campo, string $mensaje): void
    {
        $this->errores[$campo] = $mensaje;
    }

    // Datos para volver a rellenar el formulario
    public function datos(): array
    {
        return [
            'username' => $this->username,
            'email'    => $this->email,
        ];
    }

    public function username(): string
    {
        return $this->username;
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
<?php
declare(strict_types=1);

class JugadorModel
{
    private string $ruta;

    public function __construct(string $ruta)
    {
        $this->ruta = $ruta;
    }

    // Devuelve todos los jugadores del JSON
    public function todos(): array
    {
        if (!file_exists($this->ruta)) {
            return [];
        }

        $json = file_get_contents($this->ruta);
        if ($json === false || trim($json) === '') {
            return [];
        }

        // Si el JSON está corrupto lanza una excepción (y se verá la página 500)
        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    // ¿Existe ya ese usuario?
    public function existeUsername(string $username): bool
    {
        foreach ($this->todos() as $jugador) {
            if (mb_strtolower($jugador['username']) === mb_strtolower($username)) {
                return true;
            }
        }
        return false;
    }

    // ¿Existe ya ese correo?
    public function existeEmail(string $email): bool
    {
        foreach ($this->todos() as $jugador) {
            if (mb_strtolower($jugador['email']) === mb_strtolower($email)) {
                return true;
            }
        }
        return false;
    }

    // Guarda un jugador nuevo con la contraseña cifrada
    public function crear(string $username, string $email, string $password): void
    {
        // 1. Si no existe la carpeta data/, la crea
        $carpeta = dirname($this->ruta);
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0755, true);
        }

        // 2. Leemos la lista actual
        $jugadores = $this->todos();

        // 3. Ciframos la contraseña
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // 4. Añadimos el nuevo jugador
        $nuevo_jugador = [
            'username' => $username,
            'email'    => $email,
            'password' => $password_hash,
        ];
        $jugadores[] = $nuevo_jugador;

        // 5. Guardamos la lista completa
        $json = json_encode($jugadores, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($this->ruta, $json, LOCK_EX);
    }

    // Devuelve los datos del jugador si el correo y la contraseña son correctos
    public function verificarCredenciales(string $email, string $password): ?array
    {
        foreach ($this->todos() as $jugador) {
            // 1. Buscamos el correo (sin distinguir mayúsculas)
            if (mb_strtolower($jugador['email']) === mb_strtolower($email)) {
                // 2. Comprobamos la contraseña con el hash guardado
                if (password_verify($password, $jugador['password'])) {
                    return $jugador;
                }
                return null;
            }
        }
        // 3. No existe ese correo
        return null;
    }
}
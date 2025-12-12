<?php
require_once __DIR__ . '/../../database/database.php';
 // conexión PDO

class Usuario {
    public ?int $id = null;
    public string $usuario;
    public string $password_hash;

    public function __construct(string $usuario = '', string $password = '') {
        $this->usuario = $usuario;
        if ($password !== '') {
            $this->setPassword($password);
        }
    }

    // Genera el hash de la contraseña
    public function setPassword(string $password): void {
        $this->password_hash = password_hash($password, PASSWORD_DEFAULT);
    }

    // Verifica la contraseña
    public function checkPassword(string $password): bool {
        return password_verify($password, $this->password_hash);
    }

    // Convierte el objeto a un array (como to_dict())
    public function toArray(): array {
        return [
            'id' => $this->id,
            'usuario' => $this->usuario
        ];
    }
}

<?php
require_once __DIR__ . '/../../database/database.php';


class Cliente {
    public ?int $id = null;
    public string $nombre;
    public ?string $fecha_registro = null;
    public bool $activo = true;

    public function __construct(string $nombre = '', bool $activo = true) {
        $this->nombre = $nombre;
        $this->activo = $activo;
        $this->fecha_registro = date('Y-m-d H:i:s');
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'fecha_registro' => $this->fecha_registro,
            'activo' => $this->activo
        ];
    }
}

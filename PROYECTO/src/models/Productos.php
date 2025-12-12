<?php
require_once __DIR__ . '/../../database/database.php';

class Producto {
    public ?int $id = null;
    public string $nombre;
    public float $precio;
    public ?string $descripcion = null;
    public bool $activo = true;

    public function __construct(string $nombre = '', float $precio = 0.0, ?string $descripcion = null, bool $activo = true) {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->activo = $activo;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'descripcion' => $this->descripcion,
            'activo' => $this->activo
        ];
    }
}

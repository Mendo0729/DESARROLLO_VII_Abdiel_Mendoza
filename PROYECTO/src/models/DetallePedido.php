<?php
require_once __DIR__ . '/../../database/database.php';
require_once __DIR__ . '/Productos.php';

class DetallePedido {
    public ?int $id = null;
    public int $pedido_id;
    public int $producto_id;
    public int $cantidad = 1;
    public float $precio_unitario;
    public float $subtotal;
    public ?Producto $producto = null;

    public function __construct(int $pedido_id = 0, int $producto_id = 0, int $cantidad = 1, float $precio_unitario = 0.0) {
        $this->pedido_id = $pedido_id;
        $this->producto_id = $producto_id;
        $this->cantidad = $cantidad;
        $this->precio_unitario = $precio_unitario;
        $this->subtotal = $cantidad * $precio_unitario;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'pedido_id' => $this->pedido_id,
            'producto_id' => $this->producto_id,
            'cantidad' => $this->cantidad,
            'precio_unitario' => $this->precio_unitario,
            'subtotal' => $this->subtotal,
            'producto' => $this->producto ? $this->producto->toArray() : null
        ];
    }
}

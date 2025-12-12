<?php
require_once __DIR__ . '/../../database/database.php';
require_once __DIR__ . '/DetallePedido.php';

class Pedido {
    public ?int $id = null;
    public int $cliente_id;
    public ?string $fecha_pedido = null;  
    public ?string $fecha_entrega = null; 
    public string $estado = 'pendiente';  
    public ?float $total = null;
    public array $detalles = [];           

    public function __construct(int $cliente_id = 0, ?string $fecha_entrega = null, string $estado = 'pendiente', ?float $total = null) {
        $this->cliente_id = $cliente_id;
        $this->fecha_entrega = $fecha_entrega;
        $this->estado = $estado;
        $this->total = $total;
        $this->fecha_pedido = date('Y-m-d H:i:s');
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'cliente_id' => $this->cliente_id,
            'fecha_pedido' => $this->fecha_pedido,
            'fecha_entrega' => $this->fecha_entrega,
            'estado' => $this->estado,
            'total' => $this->total,
            'detalles' => array_map(fn($d) => $d->toArray(), $this->detalles)
        ];
    }
}

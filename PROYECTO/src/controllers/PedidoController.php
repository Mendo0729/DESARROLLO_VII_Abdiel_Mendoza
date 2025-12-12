<?php
require_once __DIR__ . '/../../database/database.php';
require_once __DIR__ . '/../models/Pedidos.php';
require_once __DIR__ . '/../models/DetallePedido.php';
require_once __DIR__ . '/../models/Clientes.php';
require_once __DIR__ . '/../models/Productos.php';


class PedidoController {
    private $pdo;

    public function __construct() {
        $this->pdo = getPDO();
    }

    // Obtener todos los pedidos con búsqueda por estado o cliente
    public function obtenerTodos(int $pagina = 1, int $por_pagina = 10, ?string $buscar_estado = null, ?string $buscar_cliente = null): array {
        $pagina = max(1, $pagina);
        $por_pagina = max(1, min(100, $por_pagina));
        $offset = ($pagina - 1) * $por_pagina;

        $sql = "SELECT p.* FROM pedidos p 
                JOIN clientes c ON p.cliente_id = c.id
                WHERE 1=1";
        $params = [];

        if ($buscar_estado) {
            $sql .= " AND p.estado = ?";
            $params[] = $buscar_estado;
        }
        if ($buscar_cliente) {
            $sql .= " AND c.nombre LIKE ?";
            $params[] = "%$buscar_cliente%";
        }

        $sql .= " ORDER BY p.id DESC LIMIT $por_pagina OFFSET $offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $pedidos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pedido = new Pedido($row['cliente_id'], $row['estado'], $row['fecha_entrega']);
            $pedido->id = $row['id'];
            $pedido->total = $row['total'];
            $pedidos[] = $pedido;
        }

        return $pedidos;
    }

    // Obtener pedido por ID
    public function obtenerPorId(int $id): ?Pedido {
        $stmt = $this->pdo->prepare("SELECT * FROM pedidos WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        $pedido = new Pedido($row['cliente_id'], $row['estado'], $row['fecha_entrega']);
        $pedido->id = $row['id'];
        $pedido->total = $row['total'];

        // Detalles
        $stmtDet = $this->pdo->prepare("SELECT d.*, pr.nombre AS nombre_producto FROM detalle_pedido d 
                                        JOIN productos pr ON d.producto_id = pr.id 
                                        WHERE d.pedido_id = ?");
        $stmtDet->execute([$id]);
        $detalles = [];
        while ($d = $stmtDet->fetch(PDO::FETCH_ASSOC)) {
            $detalles[] = [
                'producto_id' => $d['producto_id'],
                'nombre_producto' => $d['nombre_producto'],
                'cantidad' => $d['cantidad'],
                'precio_unitario' => $d['precio_unitario'],
                'subtotal' => $d['subtotal']
            ];
        }
        $pedido->detalles = $detalles;

        return $pedido;
    }

    // Crear pedido
    public function crear(int $cliente_id, array $productos, ?string $fecha_entrega = null): ?Pedido {
        $this->pdo->beginTransaction();

        try {
            // Verificar cliente
            $stmt = $this->pdo->prepare("SELECT id FROM clientes WHERE id = ?");
            $stmt->execute([$cliente_id]);
            if (!$stmt->fetch()) {
                $this->pdo->rollBack();
                return null;
            }

            $stmt = $this->pdo->prepare("INSERT INTO pedidos (cliente_id, estado, fecha_entrega, total) VALUES (?, 'pendiente', ?, 0)");
            $stmt->execute([$cliente_id, $fecha_entrega]);
            $pedido_id = (int)$this->pdo->lastInsertId();

            $total = 0;
            foreach ($productos as $item) {
                $producto_id = $item['producto_id'] ?? 0;
                $cantidad = $item['cantidad'] ?? 0;

                if (!$producto_id || $cantidad <= 0) {
                    $this->pdo->rollBack();
                    return null;
                }

                $stmt = $this->pdo->prepare("SELECT precio, activo FROM productos WHERE id = ?");
                $stmt->execute([$producto_id]);
                $prod = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$prod || !$prod['activo']) {
                    $this->pdo->rollBack();
                    return null;
                }

                $subtotal = $prod['precio'] * $cantidad;
                $stmt = $this->pdo->prepare("INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$pedido_id, $producto_id, $cantidad, $prod['precio'], $subtotal]);

                $total += $subtotal;
            }

            // Actualizar total
            $stmt = $this->pdo->prepare("UPDATE pedidos SET total = ? WHERE id = ?");
            $stmt->execute([$total, $pedido_id]);

            $this->pdo->commit();
            return $this->obtenerPorId($pedido_id);

        } catch (Exception $e) {
            $this->pdo->rollBack();
            return null;
        }
    }

    // Actualizar pedido
    public function actualizar(int $pedido_id, array $datos): ?Pedido {
        $this->pdo->beginTransaction();
        try {
            $pedido = $this->obtenerPorId($pedido_id);
            if (!$pedido || $pedido->estado != 'pendiente') {
                $this->pdo->rollBack();
                return null;
            }

            // Actualizar fecha o estado
            if (isset($datos['fecha_entrega'])) {
                $pedido->fecha_entrega = $datos['fecha_entrega'];
            }
            if (isset($datos['estado'])) {
                $estado = $datos['estado'];
                if (!in_array($estado, ['pendiente', 'entregado', 'cancelado'])) {
                    $this->pdo->rollBack();
                    return null;
                }
                $pedido->estado = $estado;
            }

            // Actualizar detalles si vienen
            if (!empty($datos['productos'])) {
                $stmt = $this->pdo->prepare("DELETE FROM detalle_pedido WHERE pedido_id = ?");
                $stmt->execute([$pedido_id]);

                $total = 0;
                foreach ($datos['productos'] as $item) {
                    $producto_id = $item['producto_id'] ?? 0;
                    $cantidad = $item['cantidad'] ?? 0;
                    if (!$producto_id || $cantidad <= 0) {
                        $this->pdo->rollBack();
                        return null;
                    }

                    $stmt = $this->pdo->prepare("SELECT precio, activo FROM productos WHERE id = ?");
                    $stmt->execute([$producto_id]);
                    $prod = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (!$prod || !$prod['activo']) {
                        $this->pdo->rollBack();
                        return null;
                    }

                    $subtotal = $prod['precio'] * $cantidad;
                    $stmt = $this->pdo->prepare("INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$pedido_id, $producto_id, $cantidad, $prod['precio'], $subtotal]);
                    $total += $subtotal;
                }

                $pedido->total = $total;
            }

            $stmt = $this->pdo->prepare("UPDATE pedidos SET estado = ?, fecha_entrega = ?, total = ? WHERE id = ?");
            $stmt->execute([$pedido->estado, $pedido->fecha_entrega, $pedido->total, $pedido_id]);

            $this->pdo->commit();
            return $this->obtenerPorId($pedido_id);

        } catch (Exception $e) {
            $this->pdo->rollBack();
            return null;
        }
    }

    // Eliminar pedido
    public function eliminar(int $pedido_id): bool {
        $this->pdo->beginTransaction();
        try {
            $pedido = $this->obtenerPorId($pedido_id);
            if (!$pedido) {
                $this->pdo->rollBack();
                return false;
            }

            $stmt = $this->pdo->prepare("DELETE FROM detalle_pedido WHERE pedido_id = ?");
            $stmt->execute([$pedido_id]);
            $stmt = $this->pdo->prepare("DELETE FROM pedidos WHERE id = ?");
            $stmt->execute([$pedido_id]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}

<?php
require_once __DIR__ . '/../../database/database.php';
require_once __DIR__ . '/../models/Productos.php';

class ProductoController {

    private $pdo;

    public function __construct() {
        $this->pdo = getPDO();
    }

    public function obtenerTodos(int $pagina = 1, int $por_pagina = 10, ?string $buscar = null): array {
        $pagina = max(1, $pagina);
        $por_pagina = max(1, min(100, $por_pagina));
        $offset = ($pagina - 1) * $por_pagina;

        $sql = "SELECT * FROM productos WHERE activo = 1";
        $params = [];

        if ($buscar) {
            $sql .= " AND nombre LIKE ?";
            $params[] = "%$buscar%";
        }

        $sql .= " ORDER BY id DESC LIMIT $por_pagina OFFSET $offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $productos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $producto = new Producto($row['nombre'], $row['precio']);
            $producto->id = $row['id'];
            $producto->descripcion = $row['descripcion'];
            $producto->activo = (bool)$row['activo'];
            $productos[] = $producto;
        }

        return $productos;
    }


    public function obtenerPorId(int $id): ?Producto {
        $stmt = $this->pdo->prepare("SELECT * FROM productos WHERE id = ? AND activo = 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        $producto = new Producto($row['nombre'], $row['precio']);
        $producto->id = $row['id'];
        $producto->descripcion = $row['descripcion'];
        $producto->activo = (bool)$row['activo'];
        return $producto;
    }

    public function crear(array $data): ?Producto {
        $nombre = trim($data['nombre'] ?? '');
        $precio = $data['precio'] ?? 0;

        if (!$nombre || strlen($nombre) > 100 || !is_numeric($precio) || $precio <= 0) {
            return null;
        }

        $stmt = $this->pdo->prepare("SELECT id FROM productos WHERE nombre = ?");
        $stmt->execute([$nombre]);
        if ($stmt->fetch()) return null;

        $stmt = $this->pdo->prepare("INSERT INTO productos (nombre, precio, descripcion, activo) VALUES (?, ?, ?, 1)");
        $stmt->execute([$nombre, $precio, $data['descripcion'] ?? '']);
        $id = (int)$this->pdo->lastInsertId();

        $producto = new Producto($nombre, $precio);
        $producto->id = $id;
        $producto->descripcion = $data['descripcion'] ?? '';
        $producto->activo = true;
        return $producto;
    }

    public function actualizar(int $id, array $data): ?Producto {
        $producto = $this->obtenerPorId($id);
        if (!$producto) return null;

        if (isset($data['nombre'])) {
            $nombre = trim($data['nombre']);
            if (!$nombre || strlen($nombre) > 100) return null;

            $stmt = $this->pdo->prepare("SELECT id FROM productos WHERE nombre = ? AND id != ?");
            $stmt->execute([$nombre, $id]);
            if ($stmt->fetch()) return null;

            $producto->nombre = $nombre;
        }

        if (isset($data['precio'])) {
            $precio = $data['precio'];
            if (!is_numeric($precio) || $precio <= 0) return null;
            $producto->precio = $precio;
        }

        if (isset($data['descripcion'])) {
            $producto->descripcion = trim($data['descripcion']);
        }

        if (isset($data['activo'])) {
            $producto->activo = (bool)$data['activo'];
        }

        $stmt = $this->pdo->prepare("UPDATE productos SET nombre = ?, precio = ?, descripcion = ?, activo = ? WHERE id = ?");
        $stmt->execute([$producto->nombre, $producto->precio, $producto->descripcion, $producto->activo, $id]);

        return $producto;
    }


    public function eliminar(int $id): bool {
        $producto = $this->obtenerPorId($id);
        if (!$producto) return false;

        $stmt = $this->pdo->prepare("DELETE FROM productos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

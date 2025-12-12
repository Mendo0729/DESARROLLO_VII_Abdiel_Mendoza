<?php
require_once __DIR__ . '/../../database/database.php';
require_once __DIR__ . '/../models/Clientes.php';




class ClienteController {

    private $pdo;

    public function __construct() {
        $this->pdo = getPDO();
    }

    public function obtenerTodos(int $pagina = 1, int $por_pagina = 10, ?string $buscar = null): array {
        $pagina = max(1, $pagina);
        $por_pagina = max(1, min(100, $por_pagina));
        $offset = ($pagina - 1) * $por_pagina;

        $sql = "SELECT * FROM clientes WHERE activo = 1";
        $params = [];

        if ($buscar) {
            $sql .= " AND nombre LIKE ?";
            $params[] = "%$buscar%";
        }

        $sql .= " ORDER BY id DESC LIMIT $por_pagina OFFSET $offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $clientes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cliente = new Cliente($row['nombre']);
            $cliente->id = $row['id'];
            $cliente->fecha_registro = $row['fecha_registro'];
            $cliente->activo = (bool)$row['activo'];
            $clientes[] = $cliente;
        }

        return $clientes;
    }

    public function obtenerPorId(int $id): ?Cliente {
        $stmt = $this->pdo->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        $cliente = new Cliente($row['nombre']);
        $cliente->id = $row['id'];
        $cliente->fecha_registro = $row['fecha_registro'];
        $cliente->activo = (bool)$row['activo'];
        return $cliente;
    }

    public function crear(array $data): ?Cliente {
        $nombre = trim($data['nombre'] ?? '');
        if (!$nombre || strlen($nombre) > 100) return null;

        $stmt = $this->pdo->prepare("SELECT id FROM clientes WHERE nombre = ?");
        $stmt->execute([$nombre]);
        if ($stmt->fetch()) return null;

        $stmt = $this->pdo->prepare("INSERT INTO clientes (nombre, activo, fecha_registro) VALUES (?, 1, NOW())");
        $stmt->execute([$nombre]);
        $id = (int)$this->pdo->lastInsertId();

        $cliente = new Cliente($nombre);
        $cliente->id = $id;
        $cliente->fecha_registro = date('Y-m-d H:i:s');
        $cliente->activo = true;
        return $cliente;
    }

    public function actualizar(int $id, array $data): ?Cliente {
        $cliente = $this->obtenerPorId($id);
        if (!$cliente) return null;

        $nuevo_nombre = trim($data['nombre'] ?? '');
        if (!$nuevo_nombre || strlen($nuevo_nombre) > 100) return null;

        $stmt = $this->pdo->prepare("SELECT id FROM clientes WHERE nombre = ? AND id != ?");
        $stmt->execute([$nuevo_nombre, $id]);
        if ($stmt->fetch()) return null;

        $stmt = $this->pdo->prepare("UPDATE clientes SET nombre = ? WHERE id = ?");
        $stmt->execute([$nuevo_nombre, $id]);

        $cliente->nombre = $nuevo_nombre;
        return $cliente;
    }

    public function eliminar(int $id): bool {
        $cliente = $this->obtenerPorId($id);
        if (!$cliente) return false;

        $stmt = $this->pdo->prepare("DELETE FROM clientes WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

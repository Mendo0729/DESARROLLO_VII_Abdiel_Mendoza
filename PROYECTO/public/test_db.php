<?php
require_once __DIR__ . '/../database/database.php';

try {
    $pdo = getPDO();
    echo "¡Conexión exitosa a MySQL!";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

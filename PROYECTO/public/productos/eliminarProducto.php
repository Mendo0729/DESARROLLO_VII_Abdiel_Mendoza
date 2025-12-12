<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

require_once __DIR__ . '/../../src/controllers/ProductosController.php';

$controller = new ProductoController();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID de producto no válido.');
}

$id = (int)$_GET['id'];
$eliminado = $controller->eliminar($id);

if ($eliminado) {
    header('Location: listarProductos.php?mensaje=Producto+eliminado+correctamente');
    exit;
} else {
    die('No se pudo eliminar el producto. Puede que no exista.');
}

<?php
require_once 'config_sesion.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: productos.php');
    exit;
}
check_csrf();

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$cantidad = validar_entero($_POST['cantidad'] ?? 0);

if (!producto_valido($id) || !$cantidad) {
    $_SESSION['flash_error'] = 'Producto o cantidad inválida.';
    header('Location: productos.php');
    exit;
}

if (!isset($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id] = 0;
}
$_SESSION['carrito'][$id] += $cantidad;

$_SESSION['flash_success'] = 'Producto agregado al carrito.';
header('Location: ver_carrito.php');
exit;
?>

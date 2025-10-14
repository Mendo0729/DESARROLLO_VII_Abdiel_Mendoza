<?php
require_once 'config_sesion.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ver_carrito.php');
    exit;
}
check_csrf();

$eliminar_id = isset($_POST['eliminar_id']) ? (int)$_POST['eliminar_id'] : 0;
if ($eliminar_id && isset($_SESSION['carrito'][$eliminar_id])) {
    unset($_SESSION['carrito'][$eliminar_id]);
    $_SESSION['flash_success'] = 'Producto eliminado.';
} else {
    $_SESSION['flash_error'] = 'No se pudo eliminar el producto.';
}

header('Location: ver_carrito.php');
exit;
?>

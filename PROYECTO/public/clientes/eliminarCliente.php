<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

require_once __DIR__ . '/../../src/controllers/ClienteController.php';

$controller = new ClienteController();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID de cliente inválido.");
}

$eliminado = $controller->eliminar((int)$id);

if ($eliminado) {
    header('Location: listarClientes.php?mensaje=Cliente eliminado correctamente');
    exit;
} else {
    die("No se pudo eliminar el cliente o no existe.");
}
